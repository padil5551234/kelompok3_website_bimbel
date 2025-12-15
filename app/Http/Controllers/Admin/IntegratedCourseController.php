<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketUjian;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IntegratedCourseController extends Controller
{
    /**
     * Display integrated course management dashboard
     */
    public function dashboard()
    {
        $courses = PaketUjian::withCount('materials')->get();
        $totalMaterials = Material::count();
        $totalTutors = User::count(); // Fixed: count all users instead of filtering by role
        
        return view('admin.integrated-dashboard', compact('courses', 'totalMaterials', 'totalTutors'));
    }

    /**
     * Show form untuk create/edit course dengan chapters dan materials
     */
    public function showIntegratedForm($courseId = null)
    {
        $course = $courseId ? PaketUjian::findOrFail($courseId) : null;
        $tutors = User::all(); // Fixed: get all users instead of filtering by role
        
        // Get existing materials dengan proper ordering
        $existingMaterials = $course ? Material::where('batch_id', $course->id)
            ->orderBy('chapter_number')
            ->orderBy('material_order')
            ->get() : collect();
            
        $existingChapters = $existingMaterials->count() > 0 ? $existingMaterials->groupBy('chapter_number') : collect();
        
        return view('admin.integrated-course-form', compact('course', 'tutors', 'existingMaterials', 'existingChapters'));
    }

    /**
     * Store or update integrated course dengan chapters dan materials
     */
    public function storeIntegrated(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_description' => 'required|string',
            'category' => 'nullable|string',
            'level' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'chapters' => 'required|array',
            'chapters.*.title' => 'required|string',
            'chapters.*.materials' => 'required|array',
            'chapters.*.materials.*.title' => 'required|string',
            'chapters.*.materials.*.type' => 'required|in:youtube,document,link,video',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. Create/Update Course
            $course = PaketUjian::updateOrCreate(
                ['id' => $request->course_id],
                [
                    'nama' => $request->course_name,
                    'deskripsi' => $request->course_description,
                    'kategori' => $request->category ?? 'umum',
                    'level' => $request->level ?? 'beginner',
                    'is_active' => $request->is_active ?? true,
                ]
            );

            // 2. Handle existing materials dengan proper ordering
            if ($request->course_id) {
                $existingMaterials = Material::where('batch_id', $course->id)->get();
                
                // Log existing materials for debugging
                \Log::info('IntegratedCourse: Processing existing materials', [
                    'course_id' => $course->id,
                    'existing_count' => $existingMaterials->count(),
                    'existing_ids' => $existingMaterials->pluck('id')->toArray()
                ]);
                
                // Build mapping of form indices to actual chapter numbers
                $chapterNumberMapping = [];
                foreach ($request->chapters as $chapterIndex => $chapterData) {
                    if (isset($chapterData['chapter_number']) && !empty($chapterData['chapter_number'])) {
                        $chapterNumberMapping[$chapterIndex] = $chapterData['chapter_number'];
                    } else {
                        // For new chapters, use form index + 1 as chapter number
                        $chapterNumberMapping[$chapterIndex] = $chapterIndex + 1;
                    }
                }

                \Log::info('IntegratedCourse: Chapter number mapping', [
                    'mapping' => $chapterNumberMapping
                ]);
                
                // Get chapters to delete and materials to keep
                $chaptersToDelete = [];
                $materialsToKeep = [];
                $materialsToDelete = [];
                $hasNewMaterials = false; // Track if form contains new materials
                
                // First pass: identify chapters and materials to delete
                foreach ($request->chapters as $chapterIndex => $chapterData) {
                    // Check if chapter is marked for deletion
                    if (isset($chapterData['delete']) && !empty($chapterData['delete'])) {
                        $actualChapterNumber = $chapterNumberMapping[$chapterIndex] ?? ($chapterIndex + 1);
                        $chaptersToDelete[$chapterIndex] = $actualChapterNumber;
                        \Log::info('IntegratedCourse: Chapter marked for deletion', [
                            'chapter_index' => $chapterIndex,
                            'actual_chapter_number' => $actualChapterNumber
                        ]);
                        continue; // Skip processing materials for deleted chapters
                    }
                    
                    // Process materials for non-deleted chapters
                    foreach ($chapterData['materials'] as $materialIndex => $materialData) {
                        // Check if material is marked for deletion
                        if (isset($materialData['delete']) && !empty($materialData['delete'])) {
                            $materialsToDelete[] = $materialData['delete'];
                        }
                        // Check if material should be kept (has valid ID and not deleted)
                        elseif (isset($materialData['id']) && !empty($materialData['id'])) {
                            $materialsToKeep[] = $materialData['id'];
                        }
                        // New material (no ID) - will be created later
                        else {
                            $hasNewMaterials = true;
                            \Log::info('IntegratedCourse: Found new material', [
                                'chapter_index' => $chapterIndex,
                                'material_title' => $materialData['title'] ?? 'Untitled'
                            ]);
                        }
                    }
                }
                
                // Log materials to keep and delete for debugging
                \Log::info('IntegratedCourse: Materials analysis', [
                    'materials_to_keep' => $materialsToKeep,
                    'materials_to_delete' => $materialsToDelete,
                    'chapters_to_delete' => $chaptersToDelete,
                    'chapter_number_mapping' => $chapterNumberMapping,
                    'has_new_materials' => $hasNewMaterials,
                    'existing_materials_count' => $existingMaterials->count()
                ]);
                
                // Delete materials from chapters marked for deletion
                if (!empty($chaptersToDelete)) {
                    // Get all materials from chapters that will be deleted
                    $chapterMaterialsToDelete = [];
                    foreach ($chaptersToDelete as $chapterIndex => $actualChapterNumber) {
                        // Find materials belonging to this actual chapter number
                        $chapterMaterials = $existingMaterials->where('chapter_number', $actualChapterNumber);
                        $chapterMaterialsToDelete = array_merge($chapterMaterialsToDelete, $chapterMaterials->pluck('id')->toArray());
                        
                        \Log::info('IntegratedCourse: Processing chapter deletion', [
                            'chapter_index' => $chapterIndex,
                            'actual_chapter_number' => $actualChapterNumber,
                            'materials_found' => $chapterMaterials->count(),
                            'material_ids' => $chapterMaterials->pluck('id')->toArray()
                        ]);
                    }
                    
                    if (!empty($chapterMaterialsToDelete)) {
                        $chapterDeletedCount = Material::where('batch_id', $course->id)
                            ->whereIn('id', $chapterMaterialsToDelete)
                            ->delete();
                        
                        \Log::info('IntegratedCourse: Chapter deletions completed', [
                            'deleted_count' => $chapterDeletedCount,
                            'deleted_material_ids' => $chapterMaterialsToDelete,
                            'deleted_chapters' => $chaptersToDelete
                        ]);
                    }
                }
                
                // Delete materials yang explicitly marked for deletion
                if (!empty($materialsToDelete)) {
                    $deletedCount = Material::where('batch_id', $course->id)
                        ->whereIn('id', $materialsToDelete)
                        ->delete();
                    
                    \Log::info('IntegratedCourse: Explicit material deletions completed', [
                        'deleted_count' => $deletedCount,
                        'deleted_ids' => $materialsToDelete
                    ]);
                }
                
                // Only do implicit deletion if NO new materials and we have existing materials
                // This prevents accidental deletion of materials when adding new chapters
                if (!$hasNewMaterials && $existingMaterials->count() > 0) {
                    $implicitDeletedCount = Material::where('batch_id', $course->id)
                        ->whereNotIn('id', $materialsToKeep)
                        ->delete();
                    
                    \Log::info('IntegratedCourse: Implicit deletions completed', [
                        'implicit_deleted_count' => $implicitDeletedCount,
                        'reason' => 'No new materials in form, safe to remove orphans'
                    ]);
                } else {
                    \Log::info('IntegratedCourse: Skipping implicit deletions', [
                        'has_new_materials' => $hasNewMaterials,
                        'existing_materials_count' => $existingMaterials->count(),
                        'reason' => 'Form contains new materials or no existing materials - skip orphan removal'
                    ]);
                }
            }

            // 3. Create/Update Chapters dan Materials
            foreach ($request->chapters as $chapterIndex => $chapterData) {
                // Skip deleted chapters
                if (isset($chapterData['delete']) && !empty($chapterData['delete'])) {
                    continue;
                }
                
                foreach ($chapterData['materials'] as $materialIndex => $materialFormData) {
                    // Get actual chapter number from mapping
                    $actualChapterNumber = $chapterNumberMapping[$chapterIndex] ?? ($chapterIndex + 1);
                    
                    $updateData = [
                        'batch_id' => $course->id,
                        'tutor_id' => $request->tutor_id,
                        'title' => $materialFormData['title'],
                        'description' => $materialFormData['description'] ?? '',
                        'type' => $materialFormData['type'],
                        'mapel' => $request->category ?? 'umum',
                        'chapter_number' => $actualChapterNumber, // Use actual chapter number
                        'chapter_title' => $chapterData['title'],
                        'material_order' => $materialIndex + 1,
                        'youtube_url' => $materialFormData['type'] === 'youtube' ? $materialFormData['content_url'] : null,
                        'file_path' => $materialFormData['type'] === 'document' ? $materialFormData['content_url'] : null,
                        'external_link' => $materialFormData['type'] === 'link' ? $materialFormData['content_url'] : null,
                        'is_public' => true,
                        'is_featured' => $materialIndex === 0, // First material in chapter = featured
                        'is_completable' => true,
                        'views_count' => 0,
                        'downloads_count' => 0,
                    ];

                    // Update existing material atau create new
                    if (isset($materialFormData['id']) && !empty($materialFormData['id'])) {
                        Material::where('id', $materialFormData['id'])->update($updateData);
                        \Log::info('IntegratedCourse: Updated existing material', [
                            'material_id' => $materialFormData['id'],
                            'title' => $materialFormData['title']
                        ]);
                    } else {
                        Material::create($updateData);
                        \Log::info('IntegratedCourse: Created new material', [
                            'title' => $materialFormData['title'],
                            'chapter_number' => $actualChapterNumber
                        ]);
                    }
                }
            }

            // 4. Reorder materials untuk menjaga consistency
            $this->reorderMaterials($course->id);

            DB::commit();
            
            return redirect()->route('admin.integrated-dashboard')
                ->with('success', 'Course berhasil disimpan dengan semua materials!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Edit individual material
     */
    public function editMaterial($materialId)
    {
        $material = Material::findOrFail($materialId);
        $tutors = User::all();
        
        return view('admin.material-edit', compact('material', 'tutors'));
    }

    /**
     * Update individual material
     */
    public function updateMaterial(Request $request, $materialId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:youtube,document,link,video',
            'content_url' => 'required|string',
            'tutor_id' => 'required|exists:users,id',
        ]);

        DB::beginTransaction();
        
        try {
            $material = Material::findOrFail($materialId);
            
            $material->update([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'tutor_id' => $request->tutor_id,
                'youtube_url' => $request->type === 'youtube' ? $request->content_url : null,
                'file_path' => $request->type === 'document' ? $request->content_url : null,
                'external_link' => $request->type === 'link' ? $request->content_url : null,
            ]);

            // Reorder materials untuk menjaga consistency
            $this->reorderMaterials($material->batch_id);
            
            DB::commit();
            
            return redirect()->route('admin.integrated.edit', $material->batch_id)
                ->with('success', 'Material berhasil diupdate!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Delete individual material
     */
    public function deleteMaterial($materialId)
    {
        DB::beginTransaction();
        
        try {
            $material = Material::findOrFail($materialId);
            $batchId = $material->batch_id;
            
            $material->delete();
            
            // Reorder materials untuk menjaga consistency
            $this->reorderMaterials($batchId);
            
            DB::commit();
            
            return back()->with('success', 'Material berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Reorder materials untuk menjaga consistency numbering
     */
    private function reorderMaterials($batchId)
    {
        $materials = Material::where('batch_id', $batchId)
            ->orderBy('chapter_number')
            ->orderBy('material_order')
            ->get();
            
        $currentChapter = 0;
        $currentMaterialOrder = 0;
        
        foreach ($materials as $material) {
            if ($material->chapter_number != $currentChapter) {
                $currentChapter = $material->chapter_number;
                $currentMaterialOrder = 0;
            }
            
            $currentMaterialOrder++;
            $material->material_order = $currentMaterialOrder;
            $material->save();
        }
    }

    /**
     * Delete course dengan semua materials
     */
    public function deleteCourse($courseId)
    {
        DB::beginTransaction();
        
        try {
            // Delete materials first
            Material::where('batch_id', $courseId)->delete();
            
            // Delete course
            PaketUjian::where('id', $courseId)->delete();
            
            DB::commit();
            
            return redirect()->route('admin.integrated-dashboard')
                ->with('success', 'Course dan semua materials berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Quick duplicate course
     */
    public function duplicateCourse($courseId)
    {
        $originalCourse = PaketUjian::with('materials')->findOrFail($courseId);
        
        DB::beginTransaction();
        
        try {
            // Create new course
            $newCourse = PaketUjian::create([
                'nama' => $originalCourse->nama . ' (Copy)',
                'deskripsi' => $originalCourse->deskripsi,
                'kategori' => $originalCourse->kategori,
                'level' => $originalCourse->level,
                'is_active' => $originalCourse->is_active,
            ]);

            // Copy materials
            foreach ($originalCourse->materials as $material) {
                $newMaterial = $material->replicate();
                $newMaterial->batch_id = $newCourse->id;
                $newMaterial->save();
            }
            
            DB::commit();
            
            return redirect()->route('admin.integrated-dashboard')
                ->with('success', 'Course berhasil diduplikasi!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show form untuk quick add materials (tanpa perlu buat course baru)
     */
    public function showQuickAddForm()
    {
        $courses = PaketUjian::orderBy('nama', 'asc')->get();
        $tutors = User::orderBy('name', 'asc')->get();
        
        return view('admin.quick-add-materials', compact('courses', 'tutors'));
    }

    /**
     * Store quick add materials (hanya material tanpa course baru)
     */
    public function storeQuickAdd(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|exists:paket_ujian,id',
                'tutor_id' => 'required|exists:users,id',
                'materials' => 'required|array',
                'materials.*.title' => 'required|string|max:255',
                'materials.*.type' => 'required|in:youtube,document,link,video',
                'materials.*.content_url' => 'required|string',
                'materials.*.description' => 'nullable|string',
                'materials.*.chapter_title' => 'nullable|string|max:255',
                'materials.*.chapter_number' => 'nullable|integer|min:1',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        DB::beginTransaction();
        
        try {
            $course = PaketUjian::findOrFail($request->course_id);
            $savedMaterials = 0;

            foreach ($request->materials as $index => $materialFormData) {
                // Tentukan chapter number
                $chapterNumber = $materialFormData['chapter_number'] ?? ($index + 1);
                $chapterTitle = $materialFormData['chapter_title'] ?? 'Chapter ' . $chapterNumber;
                
                // Get next material order for this chapter
                $nextOrder = Material::where('batch_id', $course->id)
                    ->where('chapter_number', $chapterNumber)
                    ->max('material_order') + 1;

                Material::create([
                    'batch_id' => $course->id,
                    'tutor_id' => $request->tutor_id,
                    'title' => $materialFormData['title'],
                    'description' => $materialFormData['description'],
                    'type' => $materialFormData['type'],
                    'mapel' => $course->kategori,
                    'chapter_number' => $chapterNumber,
                    'chapter_title' => $chapterTitle,
                    'material_order' => $nextOrder,
                    'youtube_url' => $materialFormData['type'] === 'youtube' ? $materialFormData['content_url'] : null,
                    'file_path' => $materialFormData['type'] === 'document' ? $materialFormData['content_url'] : null,
                    'external_link' => $materialFormData['type'] === 'link' ? $materialFormData['content_url'] : null,
                    'is_public' => true,
                    'is_featured' => false,
                    'is_completable' => true,
                    'views_count' => 0,
                    'downloads_count' => 0,
                ]);
                
                $savedMaterials++;
            }

            // Reorder materials untuk menjaga consistency
            $this->reorderMaterials($course->id);
            
            DB::commit();
            
            return redirect()->route('admin.integrated-dashboard')
                ->with('success', "Berhasil menambah {$savedMaterials} materials ke course {$course->nama}!");
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
}