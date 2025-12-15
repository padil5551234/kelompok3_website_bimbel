@extends('layouts.user.app')

@section('title', $article->title)

@section('content')
<section id="breadcrumbs" class="breadcrumbs" style="margin-top: 80px;">
    <div class="container">
        <ol>
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li><a href="{{ route('articles.index') }}">Artikel</a></li>
            <li>{{ $article->title }}</li>
        </ol>
        <h2>{{ $article->title }}</h2>
    </div>
</section>

<section id="article-detail" class="article-detail">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-8">
                <!-- Article Header -->
                <div class="article-header mb-4">
                    <span class="badge bg-primary mb-2">{{ ucfirst($article->category) }}</span>
                    @if($article->is_featured)
                    <span class="badge bg-warning text-dark mb-2"><i class="bi bi-star-fill"></i> Unggulan</span>
                    @endif
                    <h1 class="article-title">{{ $article->title }}</h1>
                    <div class="article-meta text-muted">
                        <span><i class="bi bi-person"></i> {{ $article->author->name ?? 'Admin' }}</span>
                        <span class="mx-2">|</span>
                        <span><i class="bi bi-calendar"></i> {{ $article->published_at->format('d F Y') }}</span>
                        <span class="mx-2">|</span>
                        <span><i class="bi bi-eye"></i> {{ number_format($article->views_count) }} views</span>
                    </div>
                </div>

                <!-- Featured Image -->
                @if($article->featured_image)
                <div class="article-image mb-4">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="img-fluid rounded shadow" loading="lazy">
                </div>
                @endif

                <!-- Article Excerpt -->
                @if($article->excerpt)
                <div class="article-excerpt bg-light p-4 rounded mb-4">
                    <p class="lead mb-0">{{ $article->excerpt }}</p>
                </div>
                @endif

                <!-- Article Content -->
                <div class="article-content">
                    {!! $article->content !!}
                </div>

                <!-- Tags -->
                @if($article->tags && count($article->tags) > 0)
                <div class="article-tags mt-4">
                    <h5>Tags:</h5>
                    @foreach($article->tags as $tag)
                    <span class="badge bg-secondary me-1">{{ $tag }}</span>
                    @endforeach
                </div>
                @endif

                <!-- Share Buttons -->
                <div class="article-share mt-5 pt-4 border-top">
                    <h5 class="mb-3">Bagikan Artikel:</h5>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article->slug)) }}" 
                           target="_blank" 
                           class="btn btn-primary">
                            <i class="bi bi-facebook"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('articles.show', $article->slug)) }}&text={{ urlencode($article->title) }}" 
                           target="_blank" 
                           class="btn btn-info text-white">
                            <i class="bi bi-twitter"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . route('articles.show', $article->slug)) }}" 
                           target="_blank" 
                           class="btn btn-success">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Related Articles -->
                @if($relatedArticles->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-file-text"></i> Artikel Terkait</h5>
                    </div>
                    <div class="card-body">
                        @foreach($relatedArticles as $related)
                        <div class="related-article mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            @if($related->featured_image)
                            <img src="{{ asset('storage/' . $related->featured_image) }}"
                                 alt="{{ $related->title }}"
                                 class="img-fluid rounded mb-2"
                                 style="max-height: 120px; width: 100%; object-fit: cover;"
                                 loading="lazy">
                            @endif
                            <h6 class="mb-1">
                                <a href="{{ route('articles.show', $related->slug) }}" class="text-decoration-none text-dark">
                                    {{ $related->title }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> {{ $related->published_at->format('d M Y') }}
                            </small>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Categories -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-grid"></i> Kategori</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('articles.index', ['category' => 'tips']) }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-lightbulb"></i> Tips
                            </a>
                            <a href="{{ route('articles.index', ['category' => 'strategi']) }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-graph-up"></i> Strategi Belajar
                            </a>
                            <a href="{{ route('articles.index', ['category' => 'pengumuman']) }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-megaphone"></i> Pengumuman
                            </a>
                            <a href="{{ route('articles.index', ['category' => 'motivasi']) }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-heart"></i> Motivasi
                            </a>
                            <a href="{{ route('articles.index', ['category' => 'umum']) }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-info-circle"></i> Umum
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="row mt-4">
            <div class="col-12">
                <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Artikel
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.breadcrumbs {
    padding: 20px 0;
    background-color: #f8f9fa;
}

.breadcrumbs ol {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 14px;
}

.breadcrumbs ol li + li {
    padding-left: 10px;
}

.breadcrumbs ol li + li::before {
    display: inline-block;
    padding-right: 10px;
    color: #6c757d;
    content: "/";
}

.breadcrumbs h2 {
    font-size: 28px;
    font-weight: 600;
    color: #2c3e50;
    margin-top: 10px;
}

.article-detail {
    padding: 40px 0;
}

.article-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.article-meta {
    font-size: 0.9rem;
    margin-bottom: 2rem;
}

.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-excerpt {
    font-style: italic;
    border-left: 4px solid #8b5cf6;
}

.article-image img {
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: cover;
}

.related-article h6 a:hover {
    color: #8b5cf6 !important;
}

.list-group-item:hover {
    background-color: #f8f9fa;
    color: #8b5cf6;
}

@media (max-width: 768px) {
    .article-title {
        font-size: 1.8rem;
    }
    
    .article-content {
        font-size: 1rem;
    }
}
</style>
@endsection