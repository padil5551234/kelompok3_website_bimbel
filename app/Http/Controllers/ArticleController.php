<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles
     */
    public function index(Request $request)
    {
        $query = Article::published()->with('author');

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        $articles = $query->orderBy('published_at', 'desc')->paginate(12);

        $featuredArticles = Article::published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $categories = [
            'all' => 'Semua',
            'tips' => 'Tips',
            'strategi' => 'Strategi Belajar',
            'pengumuman' => 'Pengumuman',
            'motivasi' => 'Motivasi',
            'umum' => 'Umum',
        ];

        return view('articles.index', compact('articles', 'featuredArticles', 'categories'));
    }

    /**
     * Display the specified article
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->published()
            ->with('author')
            ->firstOrFail();

        // Increment views
        $article->incrementViews();

        // Get related articles
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }
}