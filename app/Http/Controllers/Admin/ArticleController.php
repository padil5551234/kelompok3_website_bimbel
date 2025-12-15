<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.article.index');
    }

    /**
     * Get data for DataTables
     */
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $articles = Article::with('author')->latest();

            return DataTables::of($articles)
                ->addIndexColumn()
                ->addColumn('image', function ($article) {
                    if ($article->featured_image) {
                        $imageUrl = asset('storage/' . $article->featured_image);
                        return '<img src="' . $imageUrl . '" alt="' . htmlspecialchars($article->title) . '" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">';
                    }
                    return '<div style="width: 60px; height: 60px; background: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image text-muted"></i>
                            </div>';
                })
                ->addColumn('author', function ($article) {
                    return $article->author ? $article->author->name : '-';
                })
                ->addColumn('status', function ($article) {
                    $badgeClass = $article->status === 'published' ? 'badge-success' : 'badge-warning';
                    return '<span class="badge ' . $badgeClass . '">' . ucfirst($article->status) . '</span>';
                })
                ->addColumn('is_featured', function ($article) {
                    return $article->is_featured ?
                        '<span class="badge badge-primary">Featured</span>' :
                        '<span class="badge badge-secondary">Regular</span>';
                })
                ->addColumn('views', function ($article) {
                    return number_format($article->views_count);
                })
                ->addColumn('published_at', function ($article) {
                    return $article->published_at ? $article->published_at->format('d M Y') : '-';
                })
                ->addColumn('action', function ($article) {
                    $editBtn = '<a href="' . route('admin.article.edit', $article->id) . '" class="btn btn-sm btn-primary mr-1"><i class="fas fa-edit"></i></a>';
                    $viewBtn = '<a href="' . route('articles.show', $article->slug) . '" target="_blank" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i></a>';
                    $deleteBtn = '<form action="' . route('admin.article.destroy', $article->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus artikel ini?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>';
                    return $editBtn . $viewBtn . $deleteBtn;
                })
                ->rawColumns(['image', 'status', 'is_featured', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'tips' => 'Tips',
            'strategi' => 'Strategi Belajar',
            'pengumuman' => 'Pengumuman',
            'motivasi' => 'Motivasi',
            'umum' => 'Umum',
        ];
        
        return view('admin.article.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'category' => 'required|string',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'tags' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        $validated['author_id'] = Auth::id();
        
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }

        if ($validated['status'] === 'published' && !$request->has('published_at')) {
            $validated['published_at'] = now();
        }

        $validated['is_featured'] = $request->has('is_featured');

        Article::create($validated);

        return redirect()->route('admin.article.index')
            ->with('success', 'Artikel berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = [
            'tips' => 'Tips',
            'strategi' => 'Strategi Belajar',
            'pengumuman' => 'Pengumuman',
            'motivasi' => 'Motivasi',
            'umum' => 'Umum',
        ];
        
        return view('admin.article.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'category' => 'required|string',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'tags' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Set published_at if status changed to published and not already set
        if ($validated['status'] === 'published' && !$article->published_at) {
            $validated['published_at'] = now();
        }

        $validated['is_featured'] = $request->has('is_featured');

        $article->update($validated);

        return redirect()->route('admin.article.index')
            ->with('success', 'Artikel berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.article.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}