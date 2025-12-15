@extends('layouts.user.app')

@section('content')

<section id="materials-folders" class="materials-folders py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <div class="container">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="hero-section mb-4">
                <h1 class="display-4 fw-bold text-primary mb-3">Materi Pembelajaran</h1>
                <p class="lead text-muted mb-4">Akses materi pembelajaran yang telah diorganisir dalam folder pertemuan seperti kursus</p>
                <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
                    <a href="{{ route('user.materials.index') }}?view=chapters" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                        <i class="fas fa-book me-2"></i> Tampilan Bab
                    </a>
                    <a href="{{ route('user.materials.folders.index') }}" class="btn btn-primary btn-lg rounded-pill px-4 active">
                        <i class="fas fa-folder me-2"></i> Tampilan Folder
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-filter me-2"></i>Filter & Pencarian
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('user.materials.folders.index') }}" id="filterForm">
                        <input type="hidden" name="view" value="folders">
                        <div class="row g-4">
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-box me-1"></i>Paket
                                </label>
                                <select name="package" class="form-select form-select-lg border-0 shadow-sm" onchange="this.form.submit()">
                                    <option value="all" {{ request('package') == 'all' ? 'selected' : '' }}>Semua Paket</option>
                                    @foreach($purchasedPackages as $package)
                                        <option value="{{ $package->id }}" {{ request('package') == $package->id ? 'selected' : '' }}>
                                            {{ $package->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-book me-1"></i>Mata Pelajaran
                                </label>
                                <input type="text" name="mapel" class="form-control form-control-lg border-0 shadow-sm" placeholder="Cari mata pelajaran..." value="{{ request('mapel') }}">
                            </div>
                            <div class="col-lg-4 col-md-8">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-search me-1"></i>Pencarian
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="text" name="search" class="form-control border-0 shadow-sm" placeholder="Cari folder atau materi..." value="{{ request('search') }}">
                                    <button class="btn btn-primary px-4" type="submit">
                                        <i class="fas fa-search me-2"></i>Cari
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                                    <i class="fas fa-undo me-1"></i>Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($folders->isEmpty() && $standaloneMaterials->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                        <h5>Belum Ada Folder Materi</h5>
                        <p class="text-muted">
                            @if($purchasedPackages->isEmpty())
                                Anda belum membeli paket apapun. Silakan beli paket untuk mengakses materi pembelajaran.
                            @else
                                Folder materi untuk paket yang Anda beli belum tersedia.
                            @endif
                        </p>
                        @if($purchasedPackages->isEmpty())
                            <a href="{{ route('dashboard') }}#pricing" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Lihat Paket
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Folders Section -->
        @if($folders->isNotEmpty())
        <div class="row mb-5">
            <div class="col-12">
                <div class="section-header mb-4">
                    <h3 class="section-title">
                        <i class="fas fa-folder-open text-primary me-3"></i>
                        Folder Materi
                        <span class="badge bg-primary ms-2">{{ $folders->total() }}</span>
                    </h3>
                    <p class="section-subtitle text-muted">Organisasi materi pembelajaran berdasarkan pertemuan</p>
                </div>

                <div class="row g-4">
                    @foreach($folders as $folder)
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                            <div class="card folder-card h-100 border-0 shadow-sm">
                                <div class="card-header bg-gradient-primary text-white border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="folder-icon-wrapper">
                                            <i class="fas fa-folder fa-2x text-warning"></i>
                                        </div>
                                        <div class="folder-stats">
                                            <span class="badge bg-white text-primary">
                                                <i class="fas fa-file-alt me-1"></i>{{ $folder->materials->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-3">{{ $folder->title ?? 'Folder Materi' }}</h5>

                                    @if($folder->description)
                                        <p class="card-text text-muted mb-3">{{ Str::limit($folder->description, 120) }}</p>
                                    @endif

                                    <!-- Material types breakdown -->
                                    @php
                                        $materials = $folder->materials ?? collect();
                                        $materialsCount = $materials->groupBy('type')->map->count();
                                    @endphp
                                    @if($materialsCount->isNotEmpty())
                                        <div class="material-types mb-3">
                                            @foreach($materialsCount as $type => $count)
                                                <span class="badge material-type-badge me-2 mb-1">
                                                    @if($type === 'youtube')
                                                        <i class="fab fa-youtube text-danger me-1"></i>Video
                                                    @elseif($type === 'video')
                                                        <i class="fas fa-video text-danger me-1"></i>Video
                                                    @elseif($type === 'document')
                                                        <i class="fas fa-file-pdf text-primary me-1"></i>Dokumen
                                                    @elseif($type === 'link')
                                                        <i class="fas fa-link text-info me-1"></i>Link
                                                    @else
                                                        <i class="fas fa-file text-secondary me-1"></i>{{ ucfirst($type) }}
                                                    @endif
                                                    <span class="badge-count">{{ $count }}</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Tutor and batch info -->
                                    <div class="folder-meta">
                                        @if($folder->tutor)
                                            <div class="meta-item">
                                                <i class="fas fa-user-graduate text-primary me-2"></i>
                                                <span>{{ $folder->tutor->name }}</span>
                                            </div>
                                        @endif
                                        @if($folder->batch)
                                            <div class="meta-item">
                                                <i class="fas fa-graduation-cap text-success me-2"></i>
                                                <span>{{ $folder->batch->nama }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <a href="{{ route('user.materials.folders.show', $folder) }}" class="btn btn-primary w-100 rounded-pill">
                                        <i class="fas fa-folder-open me-2"></i>Buka Folder
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination for folders -->
                @if($folders->hasPages())
                <div class="row">
                    <div class="col-12">
                        {{ $folders->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Standalone Materials Section -->
        @if($standaloneMaterials->isNotEmpty())
        <div class="row">
            <div class="col-12">
                <div class="section-header mb-4">
                    <h3 class="section-title">
                        <i class="fas fa-file-alt text-secondary me-3"></i>
                        Materi Individu
                        <span class="badge bg-secondary ms-2">{{ $standaloneMaterials->count() }}</span>
                    </h3>
                    <p class="section-subtitle text-muted">Materi pembelajaran yang tersedia secara individual</p>
                </div>

                <div class="row g-4">
                    @foreach($standaloneMaterials as $material)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 material-card border-0 shadow-sm">
                                <div class="material-thumbnail position-relative">
                                    @if($material->type === 'youtube' && $material->youtube_url && $material->isValidYoutubeVideo())
                                        <img src="{{ $material->getYoutubeThumbnail() }}" alt="{{ $material->title }}" class="card-img-top" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="play-overlay d-flex align-items-center justify-content-center">
                                            <i class="fab fa-youtube fa-3x text-white"></i>
                                        </div>
                                        <div class="placeholder-thumbnail d-flex align-items-center justify-content-center" style="display: none;">
                                            <i class="fab fa-youtube fa-4x text-white"></i>
                                        </div>
                                    @elseif($material->thumbnail_path)
                                        <img src="{{ asset('storage/' . $material->thumbnail_path) }}" alt="{{ $material->title }}" class="card-img-top" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="placeholder-thumbnail d-flex align-items-center justify-content-center" style="display: none;">
                                            <i class="{{ $material->getTypeIcon() }} fa-4x text-white"></i>
                                        </div>
                                    @else
                                        <div class="placeholder-thumbnail d-flex align-items-center justify-content-center">
                                            <i class="{{ $material->getTypeIcon() }} fa-4x text-white"></i>
                                        </div>
                                    @endif
                                    <div class="material-type-indicator">
                                        <span class="badge material-type-main">
                                            @if($material->type === 'youtube')
                                                <i class="fab fa-youtube me-1"></i>YouTube
                                            @elseif($material->type === 'video')
                                                <i class="fas fa-video me-1"></i>Video
                                            @elseif($material->type === 'document')
                                                <i class="fas fa-file-pdf me-1"></i>Dokumen
                                            @elseif($material->type === 'link')
                                                <i class="fas fa-link me-1"></i>Link
                                            @else
                                                <i class="fas fa-file me-1"></i>{{ ucfirst($material->type) }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="material-badges mb-2">
                                        @if($material->mapel)
                                            <span class="badge bg-info me-1">{{ $material->mapel }}</span>
                                        @endif
                                        @if($material->batch)
                                            <span class="badge bg-success">{{ $material->batch->nama }}</span>
                                        @endif
                                    </div>
                                    <h6 class="card-title fw-bold mb-2">{{ Str::limit($material->title, 50) }}</h6>
                                    <p class="card-text text-muted small mb-3">
                                        {{ Str::limit($material->description, 80) }}
                                    </p>
                                    <div class="material-stats d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i>{{ number_format($material->views_count) }}
                                        </small>
                                        @if($material->duration_seconds)
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>{{ $material->getFormattedDuration() }}
                                            </small>
                                        @endif
                                    </div>
                                    @if($material->tutor)
                                        <div class="tutor-info">
                                            <small class="text-muted">
                                                <i class="fas fa-user-graduate me-1"></i>{{ $material->tutor->name }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('user.materials.show', $material) }}" class="btn btn-primary btn-sm flex-grow-1 rounded-pill">
                                            <i class="fas fa-eye me-1"></i>Lihat
                                        </a>
                                        @if($material->isDownloadable())
                                            <a href="{{ route('user.materials.download', $material) }}" class="btn btn-outline-secondary btn-sm rounded-pill" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
function resetFilters() {
    // Reset all form inputs
    document.getElementById('filterForm').reset();

    // Submit the form to refresh the page with default filters
    document.getElementById('filterForm').submit();
}
</script>
@endpush

@push('styles')
<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
    border-radius: 20px;
    padding: 3rem 2rem;
    color: #2c3e50;
    margin-bottom: 2rem;
    border: 2px solid rgba(255, 255, 255, 0.8);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.hero-section h1 {
    font-weight: 700;
    text-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.hero-section p {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Section Headers */
.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-title {
    font-size: 2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.section-title i {
    font-size: 1.8rem;
}

.section-subtitle {
    font-size: 1rem;
    margin-bottom: 0;
}

/* Filter Section */
.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-select, .form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-select:focus, .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Folder Cards */
.folder-card {
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
}

.folder-card:hover {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.folder-icon-wrapper {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    padding: 10px;
    display: inline-block;
}

.material-types {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.material-type-badge {
    background: #f8f9fa;
    color: #495057;
    border: 1px solid #dee2e6;
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

.badge-count {
    background: #007bff;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    margin-left: 4px;
}

.folder-meta {
    margin-top: auto;
}

.meta-item {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
    font-size: 0.85rem;
    color: #6c757d;
}

/* Material Cards */
.material-card {
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
}

.material-card:hover {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.material-thumbnail {
    height: 180px;
    overflow: hidden;
    position: relative;
}

.material-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-thumbnail {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.play-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 15px 15px 0 0;
}

.material-card:hover .play-overlay {
    opacity: 1;
}

.material-type-indicator {
    position: absolute;
    top: 10px;
    right: 10px;
}

.material-type-main {
    background: rgba(255, 255, 255, 0.9);
    color: #495057;
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 0.75rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.material-badges .badge {
    font-size: 0.7rem;
    border-radius: 15px;
}

.material-stats {
    font-size: 0.8rem;
}

.tutor-info {
    margin-top: 8px;
}

/* Empty State */
.text-center .card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.text-center .fas.fa-folder-open {
    color: #dee2e6;
    margin-bottom: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section {
        padding: 2rem 1rem;
    }

    .section-title {
        font-size: 1.5rem;
        flex-direction: column;
        gap: 10px;
    }

    .hero-section h1 {
        font-size: 2rem;
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }

    .col-xl-4, .col-xl-3 {
        margin-bottom: 1.5rem;
    }
}

@media (max-width: 576px) {
    .hero-section {
        text-align: center;
    }

    .d-flex.gap-3 {
        flex-direction: column;
        align-items: center;
    }

    .btn-lg {
        width: 100%;
        margin-bottom: 1rem;
    }

    .row.g-4 {
        --bs-gutter-x: 1rem;
    }
}

/* No animations */

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endpush