@extends('layouts.user.app')

@section('title', 'Artikel')

@section('content')
<section id="breadcrumbs" class="breadcrumbs" style="margin-top: 80px;">
    <div class="container">
        <ol>
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li>Artikel</li>
        </ol>
        <h2>Artikel & Tips Belajar</h2>
    </div>
</section>

<section id="articles" class="articles">
    <div class="container" data-aos="fade-up">
        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <form method="GET" action="{{ route('articles.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari artikel..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="all">Semua Kategori</option>
                            @foreach($categories as $key => $label)
                                @if($key !== 'all')
                                <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('articles.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Featured Articles -->
        @if($featuredArticles->count() > 0 && !request('search') && (!request('category') || request('category') == 'all'))
        <div class="row mb-5">
            <div class="col-lg-12">
                <h3 class="mb-4">Artikel Unggulan</h3>
            </div>
            @foreach($featuredArticles as $featured)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($featured->featured_image)
                    <img src="{{ asset('storage/' . $featured->featured_image) }}" class="card-img-top" alt="{{ $featured->title }}" style="height: 200px; object-fit: cover;">
                    @else
                    <div class="card-img-top bg-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-file-text text-white" style="font-size: 3rem;"></i>
                    </div>
                    @endif
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2"><i class="bi bi-star-fill"></i> Unggulan</span>
                        <span class="badge bg-primary mb-2">{{ $categories[$featured->category] ?? $featured->category }}</span>
                        <h5 class="card-title">{{ $featured->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($featured->excerpt ?? strip_tags($featured->content), 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-person"></i> {{ $featured->author->name ?? 'Admin' }}<br>
                                <i class="bi bi-calendar"></i> {{ $featured->published_at->format('d M Y') }}
                            </small>
                            <a href="{{ route('articles.show', $featured->slug) }}" class="btn btn-sm btn-primary">Baca</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- All Articles -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="mb-4">{{ request('search') || request('category') && request('category') != 'all' ? 'Hasil Pencarian' : 'Semua Artikel' }}</h3>
            </div>
            
            @forelse($articles as $article)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                    @else
                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-file-text text-white" style="font-size: 3rem;"></i>
                    </div>
                    @endif
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">{{ $categories[$article->category] ?? $article->category }}</span>
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($article->excerpt ?? strip_tags($article->content), 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-person"></i> {{ $article->author->name ?? 'Admin' }}<br>
                                <i class="bi bi-calendar"></i> {{ $article->published_at->format('d M Y') }}<br>
                                <i class="bi bi-eye"></i> {{ number_format($article->views_count) }} views
                            </small>
                            <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-sm btn-primary">Baca</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> Tidak ada artikel yang ditemukan.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $articles->links() }}
            </div>
        </div>
        @endif
    </div>
</section>

<style>
.articles .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.articles .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) !important;
}

.articles .card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.75rem;
}

.articles .card-text {
    font-size: 0.9rem;
    line-height: 1.6;
}

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
</style>
@endsection