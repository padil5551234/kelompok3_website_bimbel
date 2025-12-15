<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialFolder;
use App\Models\PaketUjian;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'profiled']);
    }

    /**
     * Display user's purchased materials
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get user's purchased packages with verified payment only
        $purchasedPackages = Pembelian::forUser($user->id)
            ->verified()
            ->with('paketUjian')
            ->get()
            ->pluck('paketUjian')
            ->filter();

        // Debug info (remove in production)
        if (app()->environment('local')) {
            \Log::info('UserMaterialController@index', [
                'user_id' => $user->id,
                'purchased_packages_count' => $purchasedPackages->count(),
                'purchased_packages' => $purchasedPackages->pluck('nama', 'id')->toArray()
            ]);
        }

        $query = Material::query();

        // Filter materials by purchased packages only
        if ($purchasedPackages->isNotEmpty()) {
            $packageIds = $purchasedPackages->pluck('id');
            $query->where(function($q) use ($packageIds) {
                $q->whereIn('batch_id', $packageIds)
                  ->orWhereNull('batch_id'); // Include materials without batch_id if user has any purchase
            });
        } else {
            // If user has no purchases, show no materials
            $query->whereRaw('1 = 0');
        }

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by package
        if ($request->has('package') && $request->package !== 'all') {
            $query->where('batch_id', $request->package);
        }

        // Filter by mapel
        if ($request->has('mapel') && !empty($request->mapel)) {
            $query->where('mapel', 'like', '%' . $request->mapel . '%');
        }

        // Search by title
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $materials = $query->with(['tutor', 'batch'])
            ->distinct('materials.id')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Enhanced debug info (remove in production)
        if (app()->environment('local')) {
            $materialIds = $materials->pluck('id')->toArray();
            $uniqueIds = array_unique($materialIds);
            \Log::info('UserMaterialController@index - Final Query', [
                'materials_count' => $materials->total(),
                'unique_materials_count' => count($uniqueIds),
                'duplicate_check' => count($materialIds) !== count($uniqueIds) ? 'DUPLICATES FOUND' : 'NO DUPLICATES',
                'materials_titles' => $materials->pluck('title')->toArray(),
                'material_ids' => $materialIds
            ]);
        }

        // Check if user wants folder view
        if ($request->has('view') && $request->view === 'folders') {
            return $this->foldersIndex($request);
        }

        // Default to chapter view (remove grid view)
        return $this->chapters($request);
    }

    /**
     * Display materials organized by chapters in a single course view
     */
    public function chapters(Request $request)
    {
        $user = Auth::user();
        
        // Get user's purchased packages with verified payment only
        $purchasedPackages = Pembelian::forUser($user->id)
            ->verified()
            ->with('paketUjian')
            ->get()
            ->pluck('paketUjian')
            ->filter();

        $query = Material::query();

        // Filter materials by purchased packages only
        if ($purchasedPackages->isNotEmpty()) {
            $packageIds = $purchasedPackages->pluck('id');
            $query->where(function($q) use ($packageIds) {
                $q->whereIn('batch_id', $packageIds)
                  ->orWhereNull('batch_id');
            });
        } else {
            $query->whereRaw('1 = 0');
        }

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by mapel
        if ($request->has('mapel') && !empty($request->mapel)) {
            $query->where('mapel', 'like', '%' . $request->mapel . '%');
        }

        // Search by title
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $materials = $query->with(['tutor', 'batch'])
            ->distinct('materials.id')
            ->orderBy('chapter_number', 'asc')
            ->orderBy('material_order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        // Group materials by chapters
        $chapters = [];
        if ($materials->isNotEmpty()) {
            $groupedMaterials = $materials->groupBy(function($item) {
                $chapterNumber = $item->chapter_number ?? 1;
                $chapterTitle = $item->chapter_title ?: 'Bab ' . $chapterNumber;
                return $chapterNumber . '|' . $chapterTitle;
            });

            foreach ($groupedMaterials as $chapterKey => $chapterMaterials) {
                list($chapterNumber, $chapterTitle) = explode('|', $chapterKey, 2);

                $chapters[] = (object) [
                    'number' => $chapterNumber,
                    'title' => $chapterTitle,
                    'materials' => $chapterMaterials->sortBy('material_order'),
                    'total_materials' => $chapterMaterials->count(),
                    'completed_materials' => \App\Models\LearningProgress::where('user_id', $user->id)
                        ->whereIn('material_id', $chapterMaterials->pluck('id'))
                        ->whereNotNull('completed_at')
                        ->count(),
                ];
            }

            // Sort chapters by number
            usort($chapters, function($a, $b) {
                return $a->number <=> $b->number;
            });
            
            // Enhanced debug info for chapters method
            if (app()->environment('local')) {
                $materialIds = $materials->pluck('id')->toArray();
                $uniqueIds = array_unique($materialIds);
                \Log::info('UserMaterialController@chapters - Final Data', [
                    'materials_count' => $materials->count(),
                    'unique_materials_count' => count($uniqueIds),
                    'duplicate_check' => count($materialIds) !== count($uniqueIds) ? 'DUPLICATES FOUND' : 'NO DUPLICATES',
                    'chapters_count' => count($chapters),
                    'chapter_summary' => array_map(function($chapter) {
                        return [
                            'number' => $chapter->number,
                            'title' => $chapter->title,
                            'materials_count' => $chapter->total_materials
                        ];
                    }, $chapters)
                ]);
            }
        }

        // Calculate overall progress
        $totalMaterials = $materials->count();
        $completedMaterials = \App\Models\LearningProgress::where('user_id', $user->id)
            ->whereIn('material_id', $materials->pluck('id'))
            ->whereNotNull('completed_at')
            ->count();

        $overallProgress = [
            'completed' => $completedMaterials,
            'total' => $totalMaterials,
            'percentage' => $totalMaterials > 0 ? round(($completedMaterials / $totalMaterials) * 100, 1) : 0
        ];

        return view('views_user.materials.chapters', compact('chapters', 'overallProgress', 'purchasedPackages', 'materials'));
    }

    /**
     * Display the specified material
     */
    public function show(Material $material)
    {
        $user = Auth::user();

        // Check if user has purchased access to this material
        $hasFullAccess = false;
        $isPreviewMode = false;

        // Allow access if user has purchased the package or has any verified purchase for materials without batch_id
        if ($material->batch_id) {
            $hasFullAccess = Pembelian::forUser($user->id)
                ->forPackage($material->batch_id)
                ->verified()
                ->exists();
        } else {
            $hasFullAccess = Pembelian::forUser($user->id)->verified()->exists();
        }

        // If no access, show preview mode
        if (!$hasFullAccess) {
            $isPreviewMode = true;
        }

        // Load batch with materials for modules
        if ($material->batch) {
            $material->load(['batch.materials' => function($q) {
                $q->with('tutor')->orderBy('chapter_number', 'asc')->orderBy('material_order', 'asc')->orderBy('created_at', 'asc');
            }]);

            // Group materials into modules (chapters)
            if ($material->batch->materials) {
                $modules = [];
                $materials = $material->batch->materials;

                // Group by chapter_number and chapter_title
                $groupedMaterials = $materials->groupBy(function($item) {
                    return $item->chapter_number . '|' . ($item->chapter_title ?: 'Bab ' . $item->chapter_number);
                });

                foreach ($groupedMaterials as $chapterKey => $chapterMaterials) {
                    list($chapterNumber, $chapterTitle) = explode('|', $chapterKey, 2);

                    $modules[] = (object) [
                        'number' => $chapterNumber,
                        'title' => $chapterTitle,
                        'materials' => $chapterMaterials->sortBy('material_order')
                    ];
                }

                // If no chapters defined, fall back to auto-grouping
                if (empty($modules)) {
                    $materials = $materials->sortBy('created_at');
                    $moduleIndex = 1;
                    $materials->chunk(2)->each(function($chunk) use (&$modules, &$moduleIndex) {
                        $modules[] = (object) [
                            'number' => $moduleIndex,
                            'title' => 'Bab ' . $moduleIndex,
                            'materials' => $chunk
                        ];
                        $moduleIndex++;
                    });
                }

                $material->batch->modules = collect($modules);
            }
        }

        // Get previous and next materials for navigation
        $previousMaterial = null;
        $nextMaterial = null;

        if ($material->batch && $material->batch->materials) {
            $materials = $material->batch->materials->sortBy('created_at')->values();
            $currentIndex = $materials->search(function($m) use ($material) {
                return $m->id === $material->id;
            });

            if ($currentIndex !== false) {
                if ($currentIndex > 0) {
                    $previousMaterial = $materials[$currentIndex - 1];
                }
                if ($currentIndex < $materials->count() - 1) {
                    $nextMaterial = $materials[$currentIndex + 1];
                }
            }
        }

        // Calculate learning progress
        $learningProgress = [
            'completed' => 0,
            'total' => 0,
            'percentage' => 0
        ];

        if ($material->batch && $material->batch->materials) {
            $totalMaterials = $material->batch->materials->count();
            $completedMaterials = \App\Models\LearningProgress::where('user_id', $user->id)
                ->whereIn('material_id', $material->batch->materials->pluck('id'))
                ->whereNotNull('completed_at')
                ->count();

            $learningProgress = [
                'completed' => $completedMaterials,
                'total' => $totalMaterials,
                'percentage' => $totalMaterials > 0 ? round(($completedMaterials / $totalMaterials) * 100, 1) : 0
            ];
        }

        // Check if current material is completed
        $isCompleted = \App\Models\LearningProgress::where('user_id', $user->id)
            ->where('material_id', $material->id)
            ->whereNotNull('completed_at')
            ->exists();

        // Increment views
        $material->incrementViews();

        return view('views_user.materials.show', compact('material', 'hasFullAccess', 'isPreviewMode', 'previousMaterial', 'nextMaterial', 'learningProgress', 'isCompleted'));
    }

    /**
     * Download material file
     */
    public function download(Material $material)
    {
        $user = Auth::user();
        
        // Check if material is downloadable
        if (!$material->isDownloadable()) {
            abort(404, 'Material tidak dapat diunduh.');
        }

        // Check if user has verified access
        $hasAccess = false;
        if ($material->batch_id) {
            $hasAccess = Pembelian::forUser($user->id)
                ->forPackage($material->batch_id)
                ->verified()
                ->exists();
        } else {
            $hasAccess = Pembelian::forUser($user->id)->verified()->exists();
        }

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh materi ini. Pastikan pembayaran paket sudah diverifikasi.');
        }

        // Increment downloads
        $material->incrementDownloads();

        return response()->download(
            storage_path('app/public/' . $material->file_path),
            $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION)
        );
    }

    /**
     * Get materials by package (for API/AJAX)
     */
    public function getMaterialsByPackage($packageId)
    {
        $user = Auth::user();
        
        // Check if user has purchased this package with verified payment
        $hasPurchased = Pembelian::forUser($user->id)
            ->forPackage($packageId)
            ->verified()
            ->exists();

        if (!$hasPurchased) {
            return response()->json(['error' => 'Anda belum membeli paket ini atau pembayaran belum diverifikasi'], 403);
        }

        $materials = Material::where('batch_id', $packageId)
            ->with('tutor')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['materials' => $materials]);
    }

    /**
     * Display materials organized in folders
     */
    public function foldersIndex(Request $request)
    {
        $user = Auth::user();
        
        // Get user's purchased packages with verified payment only
        $purchasedPackages = Pembelian::forUser($user->id)
            ->verified()
            ->with('paketUjian')
            ->get()
            ->pluck('paketUjian')
            ->filter();

        try {
            $query = MaterialFolder::query();

            // Filter folders by purchased packages only
            if ($purchasedPackages->isNotEmpty()) {
                $packageIds = $purchasedPackages->pluck('id');
                $query->where(function($q) use ($packageIds) {
                    $q->whereIn('batch_id', $packageIds)
                      ->orWhereNull('batch_id'); // Include folders without batch_id if user has any purchase
                });
            } else {
                // If user has no purchases, show no folders
                $query->whereRaw('1 = 0');
            }

            // Filter by package
            if ($request->has('package') && $request->package !== 'all') {
                $query->where('batch_id', $request->package);
            }

            // Filter by mapel (subject)
            if ($request->has('mapel') && !empty($request->mapel)) {
                $query->whereHas('materials', function($q) use ($request) {
                    $q->where('mapel', 'like', '%' . $request->mapel . '%');
                });
            }

            // Search by title
            if ($request->has('search') && !empty($request->search)) {
                $query->where(function($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('meeting_title', 'like', '%' . $request->search . '%')
                      ->orWhereHas('materials', function($mq) use ($request) {
                          $mq->where('title', 'like', '%' . $request->search . '%');
                      });
                });
            }

            $folders = $query->with(['materials' => function($q) {
                    $q->with('tutor');
                }, 'batch', 'tutor'])
                ->published()
                ->ordered()
                ->paginate(10);
        } catch (\Exception $e) {
            // If MaterialFolder table doesn't exist yet, return empty collection
            $folders = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }

        // Also get standalone materials (materials without folders)
        try {
            $standaloneMaterials = Material::whereNull('folder_id')
                ->where(function($q) use ($purchasedPackages) {
                    if ($purchasedPackages->isNotEmpty()) {
                        $packageIds = $purchasedPackages->pluck('id');
                        $q->whereIn('batch_id', $packageIds)
                          ->orWhereNull('batch_id');
                    } else {
                        $q->whereRaw('1 = 0');
                    }
                })
                ->with(['tutor', 'batch'])
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            // If folder_id column doesn't exist yet, get all materials as standalone
            $standaloneMaterials = Material::where(function($q) use ($purchasedPackages) {
                    if ($purchasedPackages->isNotEmpty()) {
                        $packageIds = $purchasedPackages->pluck('id');
                        $q->whereIn('batch_id', $packageIds)
                          ->orWhereNull('batch_id');
                    } else {
                        $q->whereRaw('1 = 0');
                    }
                })
                ->with(['tutor', 'batch'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('views_user.materials.folders.index', compact('folders', 'standaloneMaterials', 'purchasedPackages'));
    }

    /**
     * Display the specified folder with its materials
     */
    public function folderShow(MaterialFolder $folder)
    {
        $user = Auth::user();
        
        // Check if user has access to this folder
        $hasFullAccess = false;
        if ($folder->batch_id) {
            $hasFullAccess = Pembelian::forUser($user->id)
                ->forPackage($folder->batch_id)
                ->verified()
                ->exists();
        } else {
            // If no batch_id, allow access if user has any verified purchase
            $hasFullAccess = Pembelian::forUser($user->id)->verified()->exists();
        }

        if (!$hasFullAccess) {
            abort(403, 'Anda tidak memiliki akses ke folder ini. Pastikan pembayaran paket sudah diverifikasi.');
        }

        $folder->load(['materials' => function($q) {
            $q->with('tutor')->orderBy('created_at', 'desc');
        }, 'batch', 'tutor']);

        return view('views_user.materials.folders.show', compact('folder', 'hasFullAccess'));
    }

    /**
     * Get folders by package (for AJAX)
     */
    public function getFoldersByPackage($packageId)
    {
        $user = Auth::user();
        
        // Check if user has purchased this package with verified payment
        $hasPurchased = Pembelian::forUser($user->id)
            ->forPackage($packageId)
            ->verified()
            ->exists();

        if (!$hasPurchased) {
            return response()->json(['error' => 'Anda belum membeli paket ini atau pembayaran belum diverifikasi'], 403);
        }

        $folders = MaterialFolder::where('batch_id', $packageId)
            ->with(['materials' => function($q) {
                $q->with('tutor');
            }, 'tutor'])
            ->published()
            ->ordered()
            ->get();

        return response()->json(['folders' => $folders]);
    }

    /**
     * Get materials by folder (for AJAX)
     */
    public function getMaterialsByFolder(MaterialFolder $folder)
    {
        $user = Auth::user();
        
        // Check access similar to show method
        $hasAccess = false;
        if ($folder->batch_id) {
            $hasAccess = Pembelian::forUser($user->id)
                ->forPackage($folder->batch_id)
                ->verified()
                ->exists();
        } else {
            $hasAccess = Pembelian::forUser($user->id)->verified()->exists();
        }

        if (!$hasAccess) {
            return response()->json(['error' => 'Anda tidak memiliki akses'], 403);
        }

        $materials = $folder->materials()->with('tutor')->get();

        return response()->json(['materials' => $materials]);
    }
    /**
     * Upload new material (for tutors and admins)
     */
    public function uploadMaterial(Request $request)
    {
        $user = Auth::user();
        
        // Check if user has permission to upload materials
        if (!$user->hasRole('tutor') && !$user->hasRole('admin')) {
            return response()->json(['error' => 'Anda tidak memiliki permission untuk mengupload materi'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:youtube,video,document,link',
            'description' => 'nullable|string',
            'mapel' => 'required|string|max:255',
            'batch_id' => 'nullable|exists:paket_ujian,id',
            'file' => 'nullable|file|max:51200', // 50MB max
            'url' => 'nullable|url',
            'duration_seconds' => 'nullable|integer',
        ]);

        try {
            $materialData = [
                'title' => $request->title,
                'type' => $request->type,
                'description' => $request->description,
                'mapel' => $request->mapel,
                'batch_id' => $request->batch_id,
                'tutor_id' => $user->id,
                'views_count' => 0,
                'downloads_count' => 0,
                'is_published' => true,
            ];

            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('materials', $filename, 'public');
                $materialData['file_path'] = $path;
            }

            // Handle URL for youtube/link types
            if (in_array($request->type, ['youtube', 'link']) && $request->url) {
                $materialData['url'] = $request->url;
            }

            // Set duration if provided
            if ($request->duration_seconds) {
                $materialData['duration_seconds'] = $request->duration_seconds;
            }

            $material = Material::create($materialData);

            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil diupload!',
                'material' => $material
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupload materi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark material as completed by user
     */
    public function completeMaterial(Request $request, Material $material)
    {
        $user = Auth::user();
        
        // Check if user has access to this material
        $hasAccess = false;
        if ($material->batch_id) {
            $hasAccess = Pembelian::forUser($user->id)
                ->forPackage($material->batch_id)
                ->verified()
                ->exists();
        } else {
            $hasAccess = Pembelian::forUser($user->id)->verified()->exists();
        }

        if (!$hasAccess) {
            return response()->json(['error' => 'Anda tidak memiliki akses ke materi ini'], 403);
        }

        try {
            // Create or update learning progress
            $progress = \App\Models\LearningProgress::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'material_id' => $material->id,
                ],
                [
                    'completed_at' => now(),
                    'progress_percentage' => 100,
                ]
            );

            // If already exists, just update completion
            if (!$progress->wasRecentlyCreated) {
                $progress->update([
                    'completed_at' => now(),
                    'progress_percentage' => 100,
                ]);
            }

            // Check if user has completed all materials in the course
            $this->checkCourseCompletion($user, $material);

            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil ditandai sebagai selesai!',
                'progress' => $progress
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's learning progress
     */
    public function getProgress()
    {
        $user = Auth::user();
        
        $materials = Material::whereHas('batch', function($q) use ($user) {
            $q->whereIn('id', Pembelian::forUser($user->id)->verified()->pluck('paket_id'));
        })->with('batch')->get();

        $completedMaterials = \App\Models\LearningProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();

        $totalMaterials = $materials->count();
        $progressPercentage = $totalMaterials > 0 ? ($completedMaterials / $totalMaterials) * 100 : 0;

        // Progress by subject
        $progressBySubject = [];
        foreach ($materials->groupBy('mapel') as $subject => $subjectMaterials) {
            $completedInSubject = \App\Models\LearningProgress::where('user_id', $user->id)
                ->whereIn('material_id', $subjectMaterials->pluck('id'))
                ->whereNotNull('completed_at')
                ->count();
            
            $progressBySubject[$subject] = [
                'total' => $subjectMaterials->count(),
                'completed' => $completedInSubject,
                'percentage' => $subjectMaterials->count() > 0 ? ($completedInSubject / $subjectMaterials->count()) * 100 : 0
            ];
        }

        return response()->json([
            'overall_progress' => [
                'completed' => $completedMaterials,
                'total' => $totalMaterials,
                'percentage' => round($progressPercentage, 1)
            ],
            'progress_by_subject' => $progressBySubject,
            'completed_materials' => \App\Models\LearningProgress::where('user_id', $user->id)
                ->whereNotNull('completed_at')
                ->with('material')
                ->get()
        ]);
    }

    /**
     * Generate course completion certificate
     */
    public function generateCertificate(Request $request, Material $material = null)
    {
        $user = Auth::user();
        
        // If no specific material provided, generate certificate for overall course completion
        if (!$material) {
            // Check if user has completed all materials
            $materials = Material::whereHas('batch', function($q) use ($user) {
                $q->whereIn('id', Pembelian::forUser($user->id)->verified()->pluck('paket_id'));
            })->get();

            $completedMaterials = \App\Models\LearningProgress::where('user_id', $user->id)
                ->whereNotNull('completed_at')
                ->count();

            if ($completedMaterials < $materials->count() || $materials->count() === 0) {
                return response()->json(['error' => 'Anda belum menyelesaikan semua materi untuk mendapatkan sertifikat'], 400);
            }

            // Generate overall course certificate
            $certificateData = [
                'user_id' => $user->id,
                'course_name' => 'Pembelajaran Lengkap',
                'completion_date' => now(),
                'total_materials' => $materials->count(),
                'completed_materials' => $completedMaterials,
            ];
        } else {
            // Generate certificate for specific course/subject
            $materials = Material::where('mapel', $material->mapel)
                ->whereHas('batch', function($q) use ($user) {
                    $q->whereIn('id', Pembelian::forUser($user->id)->verified()->pluck('paket_id'));
                })->get();

            $completedMaterials = \App\Models\LearningProgress::where('user_id', $user->id)
                ->whereIn('material_id', $materials->pluck('id'))
                ->whereNotNull('completed_at')
                ->count();

            if ($completedMaterials < $materials->count()) {
                return response()->json(['error' => 'Anda belum menyelesaikan semua materi dalam course ini'], 400);
            }

            $certificateData = [
                'user_id' => $user->id,
                'course_name' => $material->mapel,
                'completion_date' => now(),
                'total_materials' => $materials->count(),
                'completed_materials' => $completedMaterials,
            ];
        }

        try {
            // Here you would typically generate a PDF certificate
            // For now, we'll return the certificate data
            $certificateData['certificate_id'] = 'CERT-' . strtoupper(uniqid());
            $certificateData['user_name'] = $user->name;
            
            return response()->json([
                'success' => true,
                'message' => 'Sertifikat berhasil dibuat!',
                'certificate' => $certificateData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat sertifikat: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if user has completed a course and trigger certificate generation
     */
    private function checkCourseCompletion($user, $material)
    {
        // Get all materials in the same subject/course
        $courseMaterials = Material::where('mapel', $material->mapel)
            ->whereHas('batch', function($q) use ($user) {
                $q->whereIn('id', Pembelian::forUser($user->id)->verified()->pluck('paket_id'));
            })->get();

        $completedInCourse = \App\Models\LearningProgress::where('user_id', $user->id)
            ->whereIn('material_id', $courseMaterials->pluck('id'))
            ->whereNotNull('completed_at')
            ->count();

        // If all materials in the course are completed, trigger certificate generation
        if ($completedInCourse >= $courseMaterials->count() && $courseMaterials->count() > 0) {
            // You could store this completion status or trigger notifications here
            // For now, we'll just log it
            \Log::info("User {$user->id} completed course: {$material->mapel}");
        }
    }
}