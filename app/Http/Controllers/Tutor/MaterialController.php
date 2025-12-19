<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:tutor', 'profiled']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with all materials for this tutor with relationships
        $query = Auth::user()->materials()->with(['batch']);

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

        $materials = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('tutor.materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paketUjians = \App\Models\PaketUjian::whereHas('materials', function($query) {
            $query->where('tutor_id', Auth::id());
        })->get();

        return view('tutor.materials.create', compact('paketUjians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batch_id' => 'required|exists:paket_ujian,id',
            'title' => 'required|string|max:255',
            'mapel' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'type' => 'required|in:video,document,link,youtube',
            'file' => 'required_if:type,video,document|file|mimes:pdf,doc,docx,mp4,avi,mov,wmv|max:102400', // 100MB
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

        $materialData = [
            'batch_id' => $request->batch_id,
            'title' => $request->title,
            'mapel' => $request->mapel,
            'description' => $request->description,
            'type' => $request->type,
            'youtube_url' => $request->youtube_url,
            'external_link' => $request->external_link,
            'content' => $request->input('content'),
            'tags' => $request->input('tags', []),
            'is_public' => $request->boolean('is_public', false),
            'is_featured' => $request->boolean('is_featured', false),
            'is_completable' => $request->boolean('is_completable', true),
            'chapter_number' => $request->chapter_number,
            'chapter_title' => $request->chapter_title,
            'material_order' => $request->material_order ?? 0,
            'duration_seconds' => $request->duration_seconds,
            'tutor_id' => Auth::id(),
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

        // Auto-generate thumbnail for YouTube videos
        if ($request->type === 'youtube' && $request->youtube_url) {
            $material = new Material();
            $videoId = $material->extractYoutubeVideoId($request->youtube_url);
            if ($videoId && !$request->hasFile('thumbnail')) {
                // YouTube will provide the thumbnail automatically through the model method
            }
        }

        $material = Material::create($materialData);

        return redirect()->route('tutor.materials.index')
            ->with('success', 'Materi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        // Ensure the material belongs to the current tutor
        if ($material->tutor_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke materi ini.');
        }
        
        // Increment views count
        $material->incrementViews();
        
        return view('tutor.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        $this->authorize('update', $material);

        $paketUjians = \App\Models\PaketUjian::whereHas('materials', function($query) {
            $query->where('tutor_id', Auth::id());
        })->get();

        return view('tutor.materials.edit', compact('material', 'paketUjians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $this->authorize('update', $material);

        $validator = Validator::make($request->all(), [
            'batch_id' => 'required|exists:paket_ujian,id',
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

        $materialData = [
            'batch_id' => $request->batch_id,
            'title' => $request->title,
            'mapel' => $request->mapel,
            'description' => $request->description,
            'type' => $request->type,
            'youtube_url' => $request->youtube_url,
            'external_link' => $request->external_link,
            'content' => $request->input('content'),
            'tags' => $request->input('tags', []),
            'is_public' => $request->boolean('is_public', false),
            'is_featured' => $request->boolean('is_featured', false),
            'is_completable' => $request->boolean('is_completable', true),
            'chapter_number' => $request->chapter_number,
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

        return redirect()->route('tutor.materials.index')
            ->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $this->authorize('delete', $material);
        
        // Delete files
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        if ($material->thumbnail_path) {
            Storage::disk('public')->delete($material->thumbnail_path);
        }

        $material->delete();

        return redirect()->route('tutor.materials.index')
            ->with('success', 'Materi berhasil dihapus!');
    }

    /**
     * Download the material file.
     */
    public function download(Material $material)
    {
        if (!$material->isDownloadable()) {
            abort(404);
        }

        // Increment downloads count
        $material->incrementDownloads();

        return Storage::disk('public')->download($material->file_path, $material->title);
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Material $material)
    {
        $this->authorize('update', $material);

        $material->update([
            'is_featured' => !$material->is_featured
        ]);

        $status = $material->is_featured ? 'ditampilkan' : 'disembunyikan';
        
        return redirect()->back()
            ->with('success', "Materi berhasil {$status} dari unggulan!");
    }

    /**
     * Toggle public status.
     */
    public function togglePublic(Material $material)
    {
        $this->authorize('update', $material);

        $material->update([
            'is_public' => !$material->is_public
        ]);

        $status = $material->is_public ? 'dipublikasikan' : 'diprivatkan';
        
        return redirect()->back()
            ->with('success', "Materi berhasil {$status}!");
    }

    /**
     * Get YouTube video info via AJAX.
     */
    public function getYouTubeInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'URL tidak valid'], 400);
        }

        $material = new Material();
        $videoId = $material->extractYoutubeVideoId($request->url);
        
        if (!$videoId) {
            return response()->json(['error' => 'URL YouTube tidak valid'], 400);
        }

        // Get video info using YouTube API or simple method
        $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
        $embedUrl = "https://www.youtube.com/embed/{$videoId}";

        return response()->json([
            'video_id' => $videoId,
            'thumbnail_url' => $thumbnailUrl,
            'embed_url' => $embedUrl,
        ]);
    }
}