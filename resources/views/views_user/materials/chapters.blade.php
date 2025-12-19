@extends('layouts.user.app')

@section('title', 'Materi Pembelajaran - Matematika & SKD')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<section id="materials-chapters" class="materials-chapters py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <div class="container">
        <!-- Hero Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <div class="hero-section mb-4">
                    <h1 class="display-4 fw-bold text-primary mb-3">
                        <i class="fas fa-book-open me-3"></i>Materi Pembelajaran
                    </h1>
                    <p class="lead text-muted mb-4">Materi pembelajaran Matematika dan SKD yang telah Anda beli, diorganisir berdasarkan bab dan chapter</p>
                    <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
                        <a href="{{ route('user.materials.index') }}?view=chapters" class="btn btn-primary btn-lg rounded-pill px-4 active">
                            <i class="fas fa-book me-2"></i> Tampilan Bab
                        </a>
                        <a href="{{ route('user.materials.index') }}?view=folders" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                            <i class="fas fa-folder me-2"></i> Tampilan Folder
                        </a>
                    </div>

                    <!-- Subject Indicators -->
                    <div class="subject-indicators">
                        @php
                            $hasMathematics = $materials->where('mapel', 'like', '%matematika%')->isNotEmpty();
                            $hasSKD = $materials->where('mapel', 'like', '%skd%')->isNotEmpty() || $materials->where('mapel', 'like', '%kedinasan%')->isNotEmpty();
                        @endphp

                        @if($hasMathematics && $hasSKD)
                            <span class="badge subject-badge bg-success">
                                <i class="fas fa-calculator me-1"></i>Matematika & SKD
                            </span>
                        @elseif($hasMathematics)
                            <span class="badge subject-badge bg-primary">
                                <i class="fas fa-calculator me-1"></i>Matematika
                            </span>
                        @elseif($hasSKD)
                            <span class="badge subject-badge bg-warning text-dark">
                                <i class="fas fa-graduation-cap me-1"></i>SKD
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Overall Progress -->
        @if($overallProgress['total'] > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title mb-2">
                                    <i class="fas fa-chart-line"></i> Progress Keseluruhan
                                </h5>
                                <div class="progress mb-2" style="height: 10px;">
                                    <div class="progress-bar bg-white" 
                                         style="width: {{ $overallProgress['percentage'] }}%"></div>
                                </div>
                                <p class="card-text mb-0">
                                    {{ $overallProgress['completed'] }} dari {{ $overallProgress['total'] }} materi telah diselesaikan
                                    ({{ $overallProgress['percentage'] }}%)
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="display-6 fw-bold">{{ $overallProgress['percentage'] }}%</div>
                                <small>Selesai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

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
                        <form method="GET" action="{{ route('user.materials.index') }}" id="filterForm">
                            <input type="hidden" name="view" value="chapters">
                            <div class="row g-4">
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-video me-1"></i>Tipe Materi
                                    </label>
                                    <select name="type" class="form-select form-select-lg border-0 shadow-sm" onchange="this.form.submit()">
                                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                                        <option value="youtube" {{ request('type') == 'youtube' ? 'selected' : '' }}>Video YouTube</option>
                                        <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                                        <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Dokumen</option>
                                        <option value="link" {{ request('type') == 'link' ? 'selected' : '' }}>Link</option>
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
                                        <input type="text" name="search" class="form-control border-0 shadow-sm" placeholder="Cari materi atau bab..." value="{{ request('search') }}">
                                        <button class="btn btn-primary px-4" type="submit">
                                            <i class="fas fa-search me-2"></i>Cari
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-secondary w-100 rounded-pill" onclick="resetFilters()">
                                        <i class="fas fa-undo me-1"></i>Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(empty($chapters))
            <div class="row">
                <div class="col-12">
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                            <h5>Belum Ada Materi</h5>
                            <p class="text-muted">
                                @if($purchasedPackages->isEmpty())
                                    Anda belum membeli paket apapun. Silakan beli paket untuk mengakses materi pembelajaran.
                                @else
                                    Materi untuk paket yang Anda beli belum tersedia.
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
            <!-- Chapters Display -->
            <div class="row">
                <div class="col-12">
                    <div class="section-header mb-4">
                        <h3 class="section-title">
                            <i class="fas fa-book-open text-primary me-3"></i>
                            Bab Pembelajaran
                            <span class="badge bg-primary ms-2">{{ count($chapters) }}</span>
                        </h3>
                        <p class="section-subtitle text-muted">Klik pada bab untuk melihat materi yang tersedia</p>
                    </div>

                    @foreach($chapters as $chapter)
                        @php
                            // Determine subject from materials in this chapter
                            $chapterMaterials = $chapter->materials;
                            $hasMathematics = $chapterMaterials->where('mapel', 'like', '%matematika%')->isNotEmpty();
                            $hasSKD = $chapterMaterials->where('mapel', 'like', '%skd%')->isNotEmpty() || $chapterMaterials->where('mapel', 'like', '%kedinasan%')->isNotEmpty();
                            $subjectClass = $hasMathematics ? 'matematika' : ($hasSKD ? 'skd' : 'other');
                        @endphp
                        <div class="card mb-4 chapter-card border-0 shadow-sm chapter-{{ $subjectClass }}">
                            <div class="card-header chapter-header chapter-header-{{ $subjectClass }}"
                             data-bs-toggle="collapse"
                             data-bs-target="#chapter-{{ $chapter->number }}-{{ $subjectClass }}"
                             aria-expanded="true"
                             aria-controls="chapter-{{ $chapter->number }}-{{ $subjectClass }}">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-chevron-down chapter-toggle me-3"></i>
                                            <div>
                                                <h5 class="mb-1 fw-bold">{{ $chapter->title }}</h5>
                                                <div class="chapter-meta">
                                                    <span class="badge material-count-badge me-2">
                                                        <i class="fas fa-file-alt me-1"></i>{{ $chapter->total_materials }} materi
                                                    </span>
                                                    @if($chapter->completed_materials > 0)
                                                        <span class="badge completed-badge">
                                                            <i class="fas fa-check-circle me-1"></i>{{ $chapter->completed_materials }} selesai
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        @if($chapter->total_materials > 0)
                                            <?php $chapterProgress = ($chapter->completed_materials / $chapter->total_materials) * 100; ?>
                                            <div class="progress-container">
                                                <div class="progress-circle" data-progress="{{ round($chapterProgress) }}">
                                                    <div class="progress-value">{{ round($chapterProgress) }}%</div>
                                                </div>
                                                <small class="text-muted ms-2">Progress</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="collapse show" id="chapter-{{ $chapter->number }}-{{ $subjectClass }}">
                                <div class="card-body">
                                    <div class="row g-4">
                                        @foreach($chapter->materials as $material)
                                            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                                                <div class="card material-card h-100 border-0 shadow-sm">
                                                    <div class="material-thumbnail position-relative">
                                                        @if($material->type === 'youtube' && $material->youtube_url && $material->isValidYoutubeVideo())
                                                            <img src="{{ $material->getYoutubeThumbnail() }}" alt="{{ $material->title }}" class="card-img-top" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                            <div class="play-overlay d-flex align-items-center justify-content-center">
                                                                <i class="fab fa-youtube fa-2x text-white"></i>
                                                            </div>
                                                            <div class="placeholder-thumbnail d-flex align-items-center justify-content-center" style="display: none;">
                                                                <i class="fab fa-youtube fa-3x text-white"></i>
                                                            </div>
                                                        @elseif($material->thumbnail_path)
                                                            <img src="{{ asset('storage/' . $material->thumbnail_path) }}" alt="{{ $material->title }}" class="card-img-top" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                            <div class="placeholder-thumbnail d-flex align-items-center justify-content-center" style="display: none;">
                                                                <i class="{{ $material->getTypeIcon() }} fa-3x text-white"></i>
                                                            </div>
                                                        @else
                                                            <div class="placeholder-thumbnail d-flex align-items-center justify-content-center">
                                                                <i class="{{ $material->getTypeIcon() }} fa-3x text-white"></i>
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
                                                                @php
                                                                    $isMathematics = stripos($material->mapel, 'matematika') !== false;
                                                                    $isSKD = stripos($material->mapel, 'skd') !== false || stripos($material->mapel, 'kedinasan') !== false;
                                                                @endphp

                                                                @if($isMathematics)
                                                                    <span class="badge bg-primary">
                                                                        <i class="fas fa-calculator me-1"></i>{{ $material->mapel }}
                                                                    </span>
                                                                @elseif($isSKD)
                                                                    <span class="badge bg-warning text-dark">
                                                                        <i class="fas fa-graduation-cap me-1"></i>{{ $material->mapel }}
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-info">{{ $material->mapel }}</span>
                                                                @endif
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
                                                            <button class="btn btn-success btn-sm rounded-pill" onclick="markAsComplete('{{ $material->id }}')" title="Tandai Selesai">
                                                                <i class="fas fa-check me-1"></i>Selesai
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@endsection

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

.subject-indicators {
    margin-top: 1rem;
}

.subject-badge {
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-weight: 500;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    color: #2c3e50 !important;
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
}

.form-select:focus, .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
    border-radius: 25px;
    font-weight: 500;
}

.btn:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Chapter Cards */
.chapter-card {
    border-radius: 15px;
    overflow: hidden;
    background: white;
}

.chapter-card:hover {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.chapter-header {
    color: white;
    cursor: pointer;
    border: none;
    padding: 1.5rem;
}

.chapter-header-matematika {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}


.chapter-header-skd {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    color: #212529;
}


.chapter-header-other {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
}


.chapter-toggle {
    font-size: 1.2rem;
}

.chapter-header[aria-expanded="false"] .chapter-toggle {
    transform: rotate(-90deg);
}

.chapter-meta {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 0.5rem;
}

.material-count-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.completed-badge {
    background: rgba(40, 167, 69, 0.9);
    color: white;
}

.progress-container {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.progress-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: conic-gradient(#28a745 var(--progress), #e9ecef 0deg);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.progress-circle::before {
    content: '';
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    position: absolute;
}

.progress-circle.progress-complete::before {
    background: #28a745;
}

.progress-value {
    position: relative;
    z-index: 1;
    font-weight: bold;
    font-size: 0.8rem;
    color: #28a745;
}

/* Material Cards */
.material-card {
    border-radius: 15px;
    overflow: hidden;
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
    border-radius: 15px 15px 0 0;
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

.text-center .fas.fa-book-open {
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

    .progress-container {
        flex-direction: column;
        gap: 5px;
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

    .chapter-meta {
        flex-direction: column;
        align-items: flex-start;
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize progress circles
    const progressCircles = document.querySelectorAll('.progress-circle');
    progressCircles.forEach(circle => {
        const progress = circle.getAttribute('data-progress');
        const degrees = Math.min((progress / 100) * 360, 359.999);
        circle.style.setProperty('--progress', degrees + 'deg');

        // Make entire circle green at 100%
        if (progress >= 100) {
            circle.classList.add('progress-complete');
        }
    });

    // Add click handler for chapter toggle
    const chapterHeaders = document.querySelectorAll('.chapter-header');
    chapterHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const toggle = this.querySelector('.chapter-toggle');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            // Update ARIA attribute
            this.setAttribute('aria-expanded', !isExpanded);
        });
    });
});

function resetFilters() {
    // Reset all form inputs
    document.getElementById('filterForm').reset();

    // Submit the form to refresh the page with default filters
    document.getElementById('filterForm').submit();
}

function markAsComplete(materialId) {
    if (confirm('Apakah Anda yakin ingin menandai materi ini sebagai selesai?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');

        // Show loading state
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
        button.disabled = true;

        fetch(`/materials/${materialId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message with better styling
                showNotification('Materi berhasil ditandai sebagai selesai!', 'success');

                // Reload the page to update progress after a short delay
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                // Reset button state
                button.innerHTML = originalText;
                button.disabled = false;

                showNotification('Terjadi kesalahan: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Reset button state
            button.innerHTML = originalText;
            button.disabled = false;

            showNotification('Terjadi kesalahan saat menyimpan progress: ' + error.message, 'error');
        });
    }
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // Add to page
    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>
@endpush