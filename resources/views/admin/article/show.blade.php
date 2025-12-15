@extends('layouts/admin/app')

@section('title')
Detail Artikel
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="{{ route('admin.article.index') }}">Artikel</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $article->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.article.edit', $article->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.article.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Status:</th>
                                    <td>
                                        @if($article->status === 'published')
                                            <span class="badge badge-success">Published</span>
                                        @else
                                            <span class="badge badge-warning">Draft</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kategori:</th>
                                    <td>{{ ucfirst($article->category) }}</td>
                                </tr>
                                <tr>
                                    <th>Penulis:</th>
                                    <td>{{ $article->author ? $article->author->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Publish:</th>
                                    <td>{{ $article->published_at ? $article->published_at->format('d M Y H:i') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Featured:</th>
                                    <td>
                                        @if($article->is_featured)
                                            <span class="badge badge-primary">Ya</span>
                                        @else
                                            <span class="badge badge-secondary">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Views:</th>
                                    <td>{{ number_format($article->views_count) }}</td>
                                </tr>
                                <tr>
                                    <th>Slug:</th>
                                    <td><code>{{ $article->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th>Link:</th>
                                    <td>
                                        <a href="{{ route('articles.show', $article->slug) }}" target="_blank">
                                            Lihat di Frontend <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($article->featured_image)
                        <div class="mb-3">
                            <h5>Gambar Unggulan:</h5>
                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                 alt="{{ $article->title }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-width: 500px;">
                        </div>
                    @endif

                    @if($article->excerpt)
                        <div class="mb-3">
                            <h5>Ringkasan:</h5>
                            <p class="text-muted">{{ $article->excerpt }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <h5>Konten:</h5>
                        <div class="border rounded p-3 bg-light">
                            {!! $article->content !!}
                        </div>
                    </div>

                    @if($article->tags && count($article->tags) > 0)
                        <div class="mb-3">
                            <h5>Tags:</h5>
                            @foreach($article->tags as $tag)
                                <span class="badge badge-info mr-1">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if($article->meta_description)
                        <div class="mb-3">
                            <h5>Meta Description:</h5>
                            <p class="text-muted small">{{ $article->meta_description }}</p>
                        </div>
                    @endif

                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <strong>Dibuat:</strong> {{ $article->created_at->format('d M Y H:i') }} | 
                            <strong>Terakhir diupdate:</strong> {{ $article->updated_at->format('d M Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection