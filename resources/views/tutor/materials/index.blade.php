@extends('layouts.admin.app')

@section('title', 'Kelola Materi')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Materi</li>
@endsection

@section('content')
<section id="materials" class="materials">
    <div class="container-fluid" data-aos="fade-up">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-3">Kelola Materi Pembelajaran</h2>
                    <p class="text-muted">Kelola materi pembelajaran yang Anda buat</p>
                </div>
                <a href="{{ route('tutor.materials.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Tambah Materi
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('tutor.materials.index') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Tipe Materi</label>
                                <select name="type" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                                    <option value="youtube" {{ request('type') == 'youtube' ? 'selected' : '' }}>Video YouTube</option>
                                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                                    <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Dokumen</option>
                                    <option value="link" {{ request('type') == 'link' ? 'selected' : '' }}>Link</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Visibilitas</label>
                                <select name="visibility" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ request('visibility') == 'all' ? 'selected' : '' }}>Semua</option>
                                    <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Publik</option>
                                    <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Privat</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Cari</label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari materi..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($materials->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                        <h5>Belum Ada Materi</h5>
                        <p class="text-muted">
                            Anda belum membuat materi apapun. Mulai buat materi pembelajaran pertama Anda.
                        </p>
                        <a href="{{ route('tutor.materials.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Buat Materi Pertama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($materials as $material)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 material-card">
                        <div class="material-thumbnail">
                            @if($material->type === 'youtube' && $material->youtube_url)
                                <img src="{{ $material->getYoutubeThumbnail() }}" alt="{{ $material->title }}" class="card-img-top">
                                <div class="play-overlay">
                                    <i class="fab fa-youtube fa-3x"></i>
                                </div>
                            @elseif($material->thumbnail_path)
                                <img src="{{ asset('storage/' . $material->thumbnail_path) }}" alt="{{ $material->title }}" class="card-img-top">
                            @else
                                <div class="placeholder-thumbnail">
                                    <i class="{{ $material->getTypeIcon() }} fa-4x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ ucfirst($material->type) }}</span>
                                @if($material->is_featured)
                                    <span class="badge bg-warning">Unggulan</span>
                                @endif
                                @if($material->is_public)
                                    <span class="badge bg-success">Publik</span>
                                @else
                                    <span class="badge bg-secondary">Privat</span>
                                @endif
                                @if($material->batch)
                                    <span class="badge bg-info">{{ $material->batch->nama }}</span>
                                @endif
                            </div>
                            <h5 class="card-title">{{ Str::limit($material->title, 60) }}</h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit($material->description, 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-eye"></i> {{ number_format($material->views_count) }} views
                                </small>
                                @if($material->duration_seconds)
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $material->getFormattedDuration() }}
                                    </small>
                                @endif
                            </div>
                            @if($material->mapel)
                                <small class="text-muted">
                                    <i class="fas fa-graduation-cap"></i> {{ $material->mapel }}
                                </small>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <a href="{{ route('tutor.materials.show', $material) }}" class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="{{ route('tutor.materials.edit', $material) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tutor.materials.destroy', $material) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                {{ $materials->links() }}
            </div>
        </div>
    @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.material-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.material-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.material-thumbnail {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
}

.material-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-thumbnail {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.play-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.material-card:hover .play-overlay {
    opacity: 1;
}

.card-body {
    padding: 1.25rem;
}

.card-body .badge {
    font-size: 0.75rem;
    margin-right: 0.25rem;
    margin-bottom: 0.25rem;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    color: #2c3e50;
}

.card-text {
    margin-bottom: 1rem;
    line-height: 1.5;
    color: #6c757d;
}

.card-body .d-flex {
    margin-bottom: 0.75rem;
}

.card-body .d-flex small {
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.card-body small.text-muted {
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.card-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding: 0.75rem 1.25rem;
}

.card-footer .btn {
    font-size: 0.85rem;
    padding: 0.5rem 0.75rem;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Show success/error messages
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif
});
</script>
@endpush