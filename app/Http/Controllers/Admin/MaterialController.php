<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\PaketUjian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:admin']);
    }

    /**
     * Get the next available chapter number for a batch.
     */
    private function getNextChapterNumber($batchId)
    {
        $maxChapter = Material::where("batch_id", $batchId)
            ->whereNotNull("chapter_number")
            ->max("chapter_number");
        
        return $maxChapter ? $maxChapter + 1 : 1;
    }

    /**
     * Validate and fix chapter numbering for a batch.
     */
    private function validateAndFixChapterNumbering($batchId)
    {
        $materials = Material::where("batch_id", $batchId)
            ->whereNotNull("chapter_number")
            ->orderBy("chapter_number")
            ->get();

        if ($materials->isEmpty()) {
            return true;
        }

        $expectedChapter = 1;
        $fixed = false;

        foreach ($materials as $material) {
            if ($material->chapter_number != $expectedChapter) {
                $material->chapter_number = $expectedChapter;
                $material->save();
                $fixed = true;
            }
            $expectedChapter++;
        }

        return $fixed;
    }


    /**
     * Display a listing of materials.
     */
    public function index(Request $request)
    {
        $tutors = User::role('tutor')->orderBy('name', 'asc')->get();
        $paketUjians = PaketUjian::orderBy('nama', 'asc')->get();

        $query = Material::query();

        // Filter by tutor if specified
        if ($request->has('tutor_id') && $request->tutor_id !== 'all') {
            $query->where('tutor_id', $request->tutor_id);
        }

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by batch/package
        if ($request->has('batch_id') && $request->batch_id !== 'all') {
            $query->where('batch_id', $request->batch_id);
        }

        // Filter by visibility
        if ($request->has('visibility')) {
            if ($request->visibility === 'public') {
                $query->where('is_public', true);
            } elseif ($request->visibility === 'private') {
                $query->where('is_public', false);
            }
        }

        // Search by title
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $materials = $query->with(['tutor', 'batch'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.material.index', compact('materials', 'tutors', 'paketUjians'));
    }

    /**
     * Get materials data for DataTables.
     */
    public function data(Request $request)
    {
        $query = Material::with(['tutor', 'batch'])
            ->orderBy('created_at', 'desc');

        // Filter by tutor if specified
        if ($request->has('tutor_id') && $request->tutor_id !== 'all') {
            $query->where('tutor_id', $request->tutor_id);
        }

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by visibility
        if ($request->has('visibility')) {
            if ($request->visibility === 'public') {
                $query->where('is_public', true);
            } elseif ($request->visibility === 'private') {
                $query->where('is_public', false);
            }
        }

        // Search by title
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('tutor_name', function ($material) {
                return $material->tutor ? $material->tutor->name : 'Belum Ditentukan';
            })
            ->addColumn('batch_name', function ($material) {
                return $material->batch ? $material->batch->nama : 'N/A';
            })
            ->addColumn('type_badge', function ($material) {
                $badges = [
                    'video' => '<span class="badge bg-danger">Video</span>',
                    'document' => '<span class="badge bg-primary">Dokumen</span>',
                    'link' => '<span class="badge bg-info">Link</span>',
                    'youtube' => '<span class="badge bg-danger">YouTube</span>',
                ];
                return $badges[$material->type] ?? '<span class="badge bg-secondary">Lainnya</span>';
            })
            ->addColumn('visibility_badge', function ($material) {
                $badge = $material->is_public 
                    ? '<span class="badge bg-success">Publik</span>' 
                    : '<span class="badge bg-warning">Privat</span>';
                return $badge;
            })
            ->addColumn('featured_badge', function ($material) {
                $badge = $material->is_featured 
                    ? '<span class="badge bg-warning">Unggulan</span>' 
                    : '';
                return $badge;
            })
            ->addColumn('aksi', function ($material) {
                return view('admin.material.actions', compact('material'));
            })
            ->editColumn('created_at', function ($material) {
                return $material->created_at->format('d/m/Y H:i');
            })
            ->editColumn('file_size', function ($material) {
                return $material->getFormattedFileSize();
            })
            ->rawColumns(['type_badge', 'visibility_badge', 'featured_badge', 'aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new material.
     */
    public function create()
    {
        $tutors = User::role('tutor')->orderBy('name', 'asc')->get();
        $paketUjians = PaketUjian::orderBy('nama', 'asc')->get();
        
        return view('admin.material.form', compact('tutors', 'paketUjians'));
    }

    /**
     * Store a newly created material.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batch_id' => 'required|exists:paket_ujian,id',
            'tutor_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'mapel' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'type' => 'required|in:video,document,link,youtube',
            'file' => 'required_if:type,video,document|file|mimes:pdf,doc,docx,mp4,avi,mov,wmv|max:102400',
            'youtube_url' => 'required_if:type,youtube|nullable|url',
            'external_link' => 'required_if:type,link|nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'nullable|string',
            'tags' => 'nullable|array',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'is_completable' => 'boolean',
            'duration_seconds' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Process tags - convert comma-separated string to array
        $tags = $request->input('tags', []);
        if (is_string($tags) && !empty($tags)) {
            $tags = array_map('trim', explode(',', $tags));
        } elseif (!is_array($tags)) {
            $tags = [];
        }

        // Handle chapter numbering - auto-assign if not specified
        $chapterNumber = $request->chapter_number;
        if (empty($chapterNumber)) {
            // Auto-assign next chapter number
            $chapterNumber = $this->getNextChapterNumber($request->batch_id);
        } else {
            // Validate and fix numbering if chapter number is specified
            $this->validateAndFixChapterNumbering($request->batch_id);
        }

        $materialData = [
            'batch_id' => $request->batch_id,
            'tutor_id' => $request->tutor_id,
            'title' => $request->title,
            'mapel' => $request->mapel,
            'description' => $request->description,
            'type' => $request->type,
            'youtube_url' => $request->youtube_url,
            'external_link' => $request->external_link,
            'content' => $request->input('content'),
            'tags' => $tags,
            'is_public' => $request->boolean('is_public', false),
            'is_featured' => $request->boolean('is_featured', false),
            'is_completable' => $request->boolean('is_completable', true),
            'chapter_number' => $chapterNumber,
            'chapter_title' => $request->chapter_title,
            'material_order' => $request->material_order ?? 0,
            'duration_seconds' => $request->duration_seconds,
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('materials', $filename, 'public');
            
            $materialData['file_path'] = $filePath;
            $materialData['file_size'] = $file->getSize();
            $materialData['file_type'] = $file->getMimeType();
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_thumb_' . Str::random(10) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnailPath = $thumbnail->storeAs('thumbnails', $thumbnailName, 'public');
            $materialData['thumbnail_path'] = $thumbnailPath;
        }

        $material = Material::create($materialData);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil ditambahkan!',
                'material' => $material
            ]);
        }

        return redirect()->route('admin.material.index')
            ->with('success', 'Materi berhasil ditambahkan!');
    }

    /**
     * Display the specified material.
     */
    public function show(Material $material)
    {
        $material->load(['tutor', 'batch']);
        return response()->json($material);
    }

    /**
     * Show the form for editing the specified material.
     */
    public function edit(Material $material)
    {
        $tutors = User::role('tutor')->orderBy('name', 'asc')->get();
        $paketUjians = PaketUjian::orderBy('nama', 'asc')->get();
        
        return view('admin.material.form', compact('material', 'tutors', 'paketUjians'));
    }

    /**
     * Update the specified material.
     */
    public function update(Request $request, Material $material)
    {
        $validator = Validator::make($request->all(), [
            'batch_id' => 'required|exists:paket_ujian,id',
            'tutor_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'mapel' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'type' => 'required|in:video,document,link,youtube',
            'file' => 'nullable|file|mimes:pdf,doc,docx,mp4,avi,mov,wmv|max:102400',
            'youtube_url' => 'required_if:type,youtube|nullable|url',
            'external_link' => 'required_if:type,link|nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'nullable|string',
            'tags' => 'nullable|array',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'is_completable' => 'boolean',
            'chapter_number' => 'nullable|integer|min:1',
            'chapter_title' => 'nullable|string|max:255',
            'material_order' => 'nullable|integer|min:0',
            'duration_seconds' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Process tags - convert comma-separated string to array
        $tags = $request->input('tags', []);
        if (is_string($tags) && !empty($tags)) {
            $tags = array_map('trim', explode(',', $tags));
        } elseif (!is_array($tags)) {
            $tags = [];
        }

        // Handle chapter numbering - auto-assign if not specified
        $chapterNumber = $request->chapter_number;
        if (empty($chapterNumber)) {
            // Auto-assign next chapter number
            $chapterNumber = $this->getNextChapterNumber($request->batch_id);
        } else {
            // Validate and fix numbering if chapter number is specified
            $this->validateAndFixChapterNumbering($request->batch_id);
        }

        $materialData = [
            'batch_id' => $request->batch_id,
            'tutor_id' => $request->tutor_id,
            'title' => $request->title,
            'mapel' => $request->mapel,
            'description' => $request->description,
            'type' => $request->type,
            'youtube_url' => $request->youtube_url,
            'external_link' => $request->external_link,
            'content' => $request->input('content'),
            'tags' => $tags,
            'is_public' => $request->boolean('is_public', false),
            'is_featured' => $request->boolean('is_featured', false),
            'is_completable' => $request->boolean('is_completable', true),
            'chapter_number' => $chapterNumber,
            'chapter_title' => $request->chapter_title,
            'material_order' => $request->material_order ?? 0,
            'duration_seconds' => $request->duration_seconds,
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('materials', $filename, 'public');
            
            $materialData['file_path'] = $filePath;
            $materialData['file_size'] = $file->getSize();
            $materialData['file_type'] = $file->getMimeType();
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($material->thumbnail_path) {
                Storage::disk('public')->delete($material->thumbnail_path);
            }

            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_thumb_' . Str::random(10) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnailPath = $thumbnail->storeAs('thumbnails', $thumbnailName, 'public');
            $materialData['thumbnail_path'] = $thumbnailPath;
        }

        $material->update($materialData);

        return redirect()->route('admin.material.index')
            ->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified material.
     */
    public function destroy(Material $material)
    {
        try {
            // Delete files
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            if ($material->thumbnail_path) {
                Storage::disk('public')->delete($material->thumbnail_path);
            }

            $material->delete();

            return response()->json(['success' => 'Materi berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Tidak dapat menghapus materi: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Material $material)
    {
        $material->update([
            'is_featured' => !$material->is_featured
        ]);

        $status = $material->is_featured ? 'ditampilkan' : 'disembunyikan';
        
        return response()->json([
            'success' => "Materi berhasil {$status} dari unggulan!",
            'is_featured' => $material->is_featured
        ]);
    }

    /**
     * Toggle public status.
     */
    public function togglePublic(Material $material)
    {
        $material->update([
            'is_public' => !$material->is_public
        ]);

        $status = $material->is_public ? 'dipublikasikan' : 'diprivatkan';
        
        return response()->json([
            'success' => "Materi berhasil {$status}!",
            'is_public' => $material->is_public
        ]);
    }

    /**
     * Get tutors data for dropdown.
     */
    public function getTutors()
    {
        $tutors = User::role('tutor')->orderBy('name', 'asc')->get();
        return response()->json($tutors);
    }

    /**
     * Get materials by tutor.
     */
    public function getMaterialsByTutor(User $tutor)
    {
        $materials = Material::where('tutor_id', $tutor->id)
            ->with('batch')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($materials);
    }

    /**
     * Display chapter pagination view.
     */
    public function chapterPagination(Request $request)
    {
        // Get all materials with chapter information
        $materials = Material::with(['batch', 'tutor'])
            ->whereNotNull('chapter_number')
            ->orderBy('batch_id')
            ->orderBy('chapter_number')
            ->orderBy('material_order')
            ->get();

        // Group materials by batch and chapter
        $chaptersData = [];
        foreach ($materials as $material) {
            $batchName = $material->batch->nama ?? 'Unknown Batch';
            $chapterKey = "{$batchName}_chapter_{$material->chapter_number}";
            
            if (!isset($chaptersData[$chapterKey])) {
                $chaptersData[$chapterKey] = [
                    'batch_name' => $batchName,
                    'batch_id' => $material->batch_id,
                    'chapter_number' => $material->chapter_number,
                    'chapter_title' => $material->chapter_title ?? "Chapter {$material->chapter_number}",
                    'materials' => [],
                    'material_count' => 0,
                    'created_at' => $material->created_at
                ];
            }
            
            $chaptersData[$chapterKey]['materials'][] = $material;
            $chaptersData[$chapterKey]['material_count']++;
        }

        // Convert to collection and sort by chapter number
        $chapters = collect($chaptersData)->sortBy(function($chapter) {
            return $chapter['batch_name'] . '_' . str_pad($chapter['chapter_number'], 3, '0', STR_PAD_LEFT);
        })->values();

        // Paginate chapters (show 10 chapters per page)
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedChapters = new \Illuminate\Pagination\LengthAwarePaginator(
            $chapters->slice($offset, $perPage),
            $chapters->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Calculate statistics
        $totalChapters = $chapters->count();
        $totalMaterials = $materials->count();
        $totalBatches = $materials->groupBy('batch_id')->count();
        
        // Chapter distribution by batch
        $batchChapterStats = [];
        foreach ($chapters as $chapter) {
            $batchName = $chapter['batch_name'];
            if (!isset($batchChapterStats[$batchName])) {
                $batchChapterStats[$batchName] = 0;
            }
            $batchChapterStats[$batchName]++;
        }

        return view('admin.material.chapter-pagination', compact(
            'paginatedChapters',
            'totalChapters',
            'totalMaterials',
            'totalBatches',
            'batchChapterStats'
        ));
    }

    /**
     * Get chapter statistics for JSON response.
     */
    public function getChapterStats()
    {
        $materials = Material::with(['batch'])
            ->whereNotNull('chapter_number')
            ->get();

        $stats = [
            'total_chapters' => 0,
            'total_materials' => $materials->count(),
            'batches_with_chapters' => 0,
            'chapters_by_batch' => [],
            'recent_chapters' => []
        ];

        $chaptersData = [];
        foreach ($materials as $material) {
            $batchName = $material->batch->nama ?? 'Unknown Batch';
            $chapterKey = "{$batchName}_chapter_{$material->chapter_number}";
            
            if (!isset($chaptersData[$chapterKey])) {
                $chaptersData[$chapterKey] = [
                    'batch_name' => $batchName,
                    'batch_id' => $material->batch_id,
                    'chapter_number' => $material->chapter_number,
                    'chapter_title' => $material->chapter_title ?? "Chapter {$material->chapter_number}",
                    'material_count' => 0,
                    'created_at' => $material->created_at
                ];
            }
            
            $chaptersData[$chapterKey]['material_count']++;
        }

        $stats['total_chapters'] = count($chaptersData);
        $stats['batches_with_chapters'] = count(array_unique(array_column($chaptersData, 'batch_name')));
        
        // Chapters by batch
        $batchChapterCounts = [];
        foreach ($chaptersData as $chapter) {
            $batchName = $chapter['batch_name'];
            if (!isset($batchChapterCounts[$batchName])) {
                $batchChapterCounts[$batchName] = 0;
            }
            $batchChapterCounts[$batchName]++;
        }
        $stats['chapters_by_batch'] = $batchChapterCounts;

        // Recent chapters (last 5)
        $sortedChapters = collect($chaptersData)->sortByDesc('created_at')->take(5);
        $stats['recent_chapters'] = $sortedChapters->values()->all();

        return response()->json($stats);
    }

    /**
     * Delete a chapter and renumber subsequent chapters.
     */
    public function deleteChapter(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:paket_ujian,id',
            'chapter_number' => 'required|integer|min:1'
        ]);

        try {
            $batchId = $request->batch_id;
            $chapterNumber = $request->chapter_number;

            // Start database transaction to ensure atomicity
            DB::beginTransaction();
            
            try {
                // Get all materials in the chapter to be deleted
                $chapterMaterials = Material::where('batch_id', $batchId)
                    ->where('chapter_number', $chapterNumber)
                    ->get();

                if ($chapterMaterials->isEmpty()) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Chapter not found or already deleted.'
                    ], 404);
                }

                $materialIds = $chapterMaterials->pluck('id')->toArray();
                \Log::info("Deleting chapter {$chapterNumber} from batch {$batchId}", [
                    'material_ids' => $materialIds,
                    'material_count' => count($materialIds)
                ]);

                // Delete all materials in this chapter
                foreach ($chapterMaterials as $material) {
                    // Delete files
                    if ($material->file_path) {
                        Storage::disk('public')->delete($material->file_path);
                    }
                    if ($material->thumbnail_path) {
                        Storage::disk('public')->delete($material->thumbnail_path);
                    }
                }
                
                // Perform the deletion
                $deletedCount = Material::whereIn('id', $materialIds)->delete();

                // Get all chapters after the deleted one
                $subsequentChapters = Material::where('batch_id', $batchId)
                    ->where('chapter_number', '>', $chapterNumber)
                    ->orderBy('chapter_number')
                    ->get();

                $renumberedCount = 0;
                // Renumber subsequent chapters
                foreach ($subsequentChapters as $material) {
                    $oldChapterNumber = $material->chapter_number;
                    $material->chapter_number = $material->chapter_number - 1;
                    $material->save();
                    $renumberedCount++;
                    
                    \Log::info("Renumbered material", [
                        'material_id' => $material->id,
                        'old_chapter' => $oldChapterNumber,
                        'new_chapter' => $material->chapter_number
                    ]);
                }

                // Commit the transaction
                DB::commit();

                \Log::info("Chapter deletion completed successfully", [
                    'batch_id' => $batchId,
                    'chapter_number' => $chapterNumber,
                    'deleted_materials' => $deletedCount,
                    'renumbered_materials' => $renumberedCount
                ]);

                return response()->json([
                    'success' => true,
                    'message' => "Chapter {$chapterNumber} deleted successfully! {$deletedCount} materials removed and {$renumberedCount} chapters renumbered.",
                    'deleted_materials' => $deletedCount,
                    'renumbered_chapters' => $renumberedCount
                ]);

            } catch (\Exception $e) {
                // Rollback on any error
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error("Chapter deletion failed", [
                'batch_id' => $request->batch_id,
                'chapter_number' => $request->chapter_number,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting chapter: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk renumber all chapters in a batch.
     */
    public function renumberChapters(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:paket_ujian,id'
        ]);

        try {
            $batchId = $request->batch_id;

            // Get all materials in the batch, grouped by chapter
            $materials = Material::where('batch_id', $batchId)
                ->whereNotNull('chapter_number')
                ->orderBy('chapter_number')
                ->orderBy('material_order')
                ->get();

            if ($materials->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No chapters found to renumber.'
                ], 404);
            }

            // Group materials by chapter number
            $chapters = $materials->groupBy('chapter_number')->sortKeys();

            $newChapterNumber = 1;
            $renumberedCount = 0;

            foreach ($chapters as $chapterNumber => $chapterMaterials) {
                foreach ($chapterMaterials as $material) {
                    if ($material->chapter_number != $newChapterNumber) {
                        $material->chapter_number = $newChapterNumber;
                        $material->save();
                        $renumberedCount++;
                    }
                }
                $newChapterNumber++;
            }

            return response()->json([
                'success' => true,
                'message' => "Chapters renumbered successfully! {$renumberedCount} materials updated.",
                'total_chapters' => $chapters->count(),
                'renumbered_materials' => $renumberedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error renumbering chapters: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get next chapter number for a batch (AJAX endpoint).
     */
    public function getNextChapter(PaketUjian $batch)
    {
        $nextChapter = $this->getNextChapterNumber($batch->id);
        
        return response()->json([
            "next_chapter" => $nextChapter
        ]);
    }
}