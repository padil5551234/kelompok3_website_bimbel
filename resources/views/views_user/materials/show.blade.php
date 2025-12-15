@extends('layouts.user.app')

@section('title', $material->title)

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container py-4">
    <!-- Learning Modules / Chapters -->
    @if($material->batch && $material->batch->modules)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-book-open"></i> Modul Pembelajaran - {{ $material->batch->nama }}
                        </h5>
                        @if(isset($learningProgress))
                        <div class="text-end">
                            <small class="text-muted">Progress Belajar</small>
                            <div class="progress" style="width: 150px; height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ $learningProgress['percentage'] }}%"
                                     aria-valuenow="{{ $learningProgress['percentage'] }}"
                                     aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <small class="text-muted">
                                {{ $learningProgress['completed'] }}/{{ $learningProgress['total'] }} materi ({{ $learningProgress['percentage'] }}%)
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="accordion" id="modulesAccordion">
                        @foreach($material->batch->modules as $index => $module)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                    <i class="fas fa-chapter me-2"></i>
                                    @if(isset($module->number) && $module->number)
                                        <strong>Bab {{ $module->number }}:</strong> {{ $module->title }}
                                    @else
                                        {{ $module->title ?? 'Bab ' . ($index + 1) }}
                                    @endif
                                    @if($module->materials)
                                        <span class="badge bg-secondary ms-2">{{ count($module->materials) }} materi</span>
                                    @endif
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#modulesAccordion">
                                <div class="accordion-body">
                                    @if($module->materials && count($module->materials) > 0)
                                        <div class="row g-3">
                                            @foreach($module->materials as $subMaterial)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card h-100 {{ $subMaterial->id == $material->id ? 'border-primary' : '' }}">
                                                    <div class="card-body d-flex flex-column">
                                                        <div class="d-flex align-items-start mb-2">
                                                            <div class="flex-shrink-0 me-3">
                                                                @if($subMaterial->type === 'youtube')
                                                                    <i class="fas fa-play-circle fa-2x text-danger"></i>
                                                                @elseif($subMaterial->type === 'video')
                                                                    <i class="fas fa-video fa-2x text-primary"></i>
                                                                @elseif($subMaterial->type === 'document')
                                                                    <i class="fas fa-file-pdf fa-2x text-success"></i>
                                                                @elseif($subMaterial->type === 'link')
                                                                    <i class="fas fa-link fa-2x text-info"></i>
                                                                @else
                                                                    <i class="fas fa-file fa-2x text-secondary"></i>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-1">
                                                                    <a href="{{ route('user.materials.show', $subMaterial) }}" class="text-decoration-none {{ $subMaterial->id == $material->id ? 'text-primary fw-bold' : '' }}">
                                                                        {{ $subMaterial->title }}
                                                                    </a>
                                                                </h6>
                                                                <small class="text-muted">
                                                                    @if($subMaterial->duration_seconds)
                                                                        <i class="fas fa-clock"></i> {{ $subMaterial->getFormattedDuration() }}
                                                                    @endif
                                                                    @if($subMaterial->views_count)
                                                                        <span class="ms-2"><i class="fas fa-eye"></i> {{ number_format($subMaterial->views_count) }}</span>
                                                                    @endif
                                                                </small>
                                                            </div>
                                                        </div>
                                                        @if($subMaterial->description)
                                                            <p class="card-text small text-muted flex-grow-1">{{ Str::limit($subMaterial->description, 100) }}</p>
                                                        @endif
                                                        @if($subMaterial->id == $material->id)
                                                            <div class="mt-auto">
                                                                <span class="badge bg-primary"><i class="fas fa-play"></i> Sedang Dipelajari</span>
                                                            </div>
                                                        @else
                                                            <div class="mt-auto">
                                                                <button class="btn btn-sm btn-outline-success" onclick="markAsComplete({{ $subMaterial->id }})">
                                                                    <i class="fas fa-check"></i> Tandai Selesai
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">Belum ada materi dalam bab ini.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('user.materials.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Materi
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            @if($isPreviewMode)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-lock"></i> <strong>Mode Preview</strong> - Anda sedang melihat preview materi.
                <a href="{{ route('pembelian.index') }}" class="alert-link">Beli paket</a> untuk akses penuh.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Material Header -->
                    <div class="mb-4">
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge bg-primary">{{ ucfirst($material->type) }}</span>
                            @if($material->mapel)
                                <span class="badge bg-info">{{ $material->mapel }}</span>
                            @endif
                            @if($material->batch)
                                <span class="badge bg-secondary">{{ $material->batch->nama }}</span>
                            @endif
                            @if($material->is_public)
                                <span class="badge bg-success">Publik</span>
                            @endif
                            @if($isPreviewMode)
                                <span class="badge bg-warning"><i class="fas fa-lock"></i> Preview Mode</span>
                            @endif
                        </div>
                        <h2>{{ $material->title }}</h2>
                        <div class="text-muted small mb-3">
                            <i class="fas fa-user"></i> {{ $material->tutor->name ?? 'Unknown' }}
                            <span class="mx-2">|</span>
                            <i class="fas fa-calendar"></i> {{ $material->created_at->format('d M Y') }}
                            <span class="mx-2">|</span>
                            <i class="fas fa-eye"></i> {{ number_format($material->views_count) }} views
                            @if($material->duration_seconds)
                                <span class="mx-2">|</span>
                                <i class="fas fa-clock"></i> {{ $material->getFormattedDuration() }}
                            @endif
                        </div>
                    </div>

                    <!-- Material Content -->
                    @if($material->type === 'youtube' && $material->youtube_url)
                        @if($material->isValidYoutubeVideo())
                        <div class="ratio ratio-16x9 mb-4">
                            @if($isPreviewMode)
                                <div class="preview-overlay">
                                    <iframe src="{{ $material->getYoutubeEmbedUrl() }}?start=0&end=300"
                                            title="{{ $material->title }}"
                                            frameborder="0"
                                            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                            onerror="handleVideoError(this)">
                                    </iframe>
                                    <div class="preview-lock">
                                        <div class="text-center">
                                            <i class="fas fa-lock fa-3x mb-3"></i>
                                            <h5>Preview Terbatas (5 menit pertama)</h5>
                                            <p>Beli paket untuk akses lengkap</p>
                                            <a href="{{ route('pembelian.index') }}" class="btn btn-primary">
                                                <i class="fas fa-shopping-cart"></i> Beli Sekarang
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <iframe src="{{ $material->getYoutubeEmbedUrl() }}"
                                        title="{{ $material->title }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                        onerror="handleVideoError(this)">
                                </iframe>
                            @endif
                        </div>
                        @else
                        <div class="alert alert-danger mb-4">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <h5>Video Tidak Tersedia</h5>
                                <p class="mb-3">{{ $material->getVideoErrorMessage() }}</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ $material->getYoutubeWatchUrl() }}" target="_blank" class="btn btn-danger">
                                        <i class="fab fa-youtube"></i> Buka di YouTube
                                    </a>
                                    @if(!$isPreviewMode)
                                    <button class="btn btn-outline-secondary" onclick="reportVideoIssue({{ $material->id }})">
                                        <i class="fas fa-flag"></i> Laporkan Masalah
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @elseif($material->type === 'video' && $material->file_path)
                        <div class="mb-4">
                            <video controls class="w-100" style="max-height: 500px;">
                                <source src="{{ asset('storage/' . $material->file_path) }}" type="{{ $material->file_type }}">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @elseif($material->type === 'document' && $material->file_path)
                        @if($isPreviewMode)
                            <div class="alert alert-warning mb-4">
                                <div class="text-center">
                                    <i class="fas fa-file-pdf fa-3x mb-3"></i>
                                    <h5>Preview Dokumen Tidak Tersedia</h5>
                                    <p class="mb-3">Beli paket untuk mengakses dan mengunduh dokumen lengkap</p>
                                    <a href="{{ route('pembelian.index') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-cart"></i> Beli Paket
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-pdf fa-2x"></i>
                                        <span class="ms-3">
                                            <strong>{{ basename($material->file_path) }}</strong>
                                            <br>
                                            <small>{{ $material->getFormattedFileSize() }}</small>
                                        </span>
                                    </div>
                                    <a href="{{ route('user.materials.download', $material) }}" class="btn btn-primary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                            @if(Str::endsWith($material->file_path, '.pdf'))
                                <div class="ratio ratio-16x9 mb-4">
                                    <iframe src="{{ asset('storage/' . $material->file_path) }}" frameborder="0"></iframe>
                                </div>
                            @endif
                        @endif
                    @elseif($material->type === 'link' && $material->external_link)
                        <div class="alert alert-info mb-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div class="flex-grow-1" style="min-width: 0;">
                                    <i class="fas fa-link fa-2x"></i>
                                    <span class="ms-3">
                                        <strong>Link Eksternal</strong>
                                        <br>
                                        <small class="d-block text-break" style="word-break: break-all; max-width: 100%;">{{ $material->external_link }}</small>
                                    </span>
                                </div>
                                <a href="{{ $material->external_link }}" target="_blank" class="btn btn-primary flex-shrink-0">
                                    <i class="fas fa-external-link-alt"></i> Buka Link
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Description -->
                    @if($material->description)
                        <div class="mb-4">
                            <h5>Deskripsi</h5>
                            <p class="text-muted">{{ $material->description }}</p>
                        </div>
                    @endif

                    <!-- Additional Content -->
                    @if($material->content)
                        <div class="mb-4">
                            <h5>Informasi Tambahan</h5>
                            <div class="content-section">
                                {!! nl2br(e($material->content)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Tags -->
                    @if($material->tags && count($material->tags) > 0)
                        <div class="mb-4">
                            <h6>Tags:</h6>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach($material->tags as $tag)
                                    <span class="badge bg-light text-dark">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Download Button for downloadable materials -->
                    @if($material->isDownloadable() && $hasFullAccess)
                        <div class="d-grid">
                            <a href="{{ route('user.materials.download', $material) }}" class="btn btn-lg btn-primary">
                                <i class="fas fa-download"></i> Download Materi
                                @if($material->file_size)
                                    <small>({{ $material->getFormattedFileSize() }})</small>
                                @endif
                            </a>
                            <small class="text-muted text-center mt-2">
                                <i class="fas fa-download"></i> {{ number_format($material->downloads_count) }} downloads
                            </small>
                        </div>
                    @elseif($material->isDownloadable() && !$hasFullAccess)
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-lock mb-2"></i>
                            <p class="mb-2">Download hanya tersedia untuk member</p>
                            <a href="{{ route('pembelian.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Beli Paket
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Navigation -->
            @if(isset($previousMaterial) || isset($nextMaterial))
            <div class="d-flex justify-content-between mt-4">
                @if($previousMaterial)
                <a href="{{ route('user.materials.show', $previousMaterial) }}" class="btn btn-outline-primary">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                    <br>
                    <small class="text-muted">{{ Str::limit($previousMaterial->title, 30) }}</small>
                </a>
                @else
                <div></div>
                @endif

                @if($nextMaterial)
                <a href="{{ route('user.materials.show', $nextMaterial) }}" class="btn btn-outline-primary">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                    <br>
                    <small class="text-muted">{{ Str::limit($nextMaterial->title, 30) }}</small>
                </a>
                @else
                <div></div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Material Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Informasi Materi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Tipe</small>
                        <p class="mb-0">{{ ucfirst($material->type) }}</p>
                    </div>
                    @if($material->mapel)
                        <div class="mb-3">
                            <small class="text-muted">Mata Pelajaran</small>
                            <p class="mb-0">{{ $material->mapel }}</p>
                        </div>
                    @endif
                    @if($material->batch)
                        <div class="mb-3">
                            <small class="text-muted">Paket</small>
                            <p class="mb-0">{{ $material->batch->nama }}</p>
                        </div>
                    @endif
                    @if($material->tutor)
                        <div class="mb-3">
                            <small class="text-muted">Pengajar</small>
                            <p class="mb-0">{{ $material->tutor->name }}</p>
                        </div>
                    @endif
                    <div class="mb-3">
                        <small class="text-muted">Ditambahkan</small>
                        <p class="mb-0">{{ $material->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <small class="text-muted">Terakhir Diupdate</small>
                        <p class="mb-0">{{ $material->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span><i class="fas fa-eye text-primary"></i> Views</span>
                        <strong>{{ number_format($material->views_count) }}</strong>
                    </div>
                    @if($material->isDownloadable())
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-download text-success"></i> Downloads</span>
                            <strong>{{ number_format($material->downloads_count) }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Completion Status -->
            @if($hasFullAccess && $material->is_completable)
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Status Pembelajaran</h6>
                </div>
                <div class="card-body">
                    @if($isCompleted)
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle"></i> Materi ini telah selesai dipelajari
                        </div>
                        <div class="text-muted small">
                            <i class="fas fa-calendar-check"></i> Ditandai selesai
                        </div>
                    @else
                        <div class="d-grid">
                            <button class="btn btn-success btn-lg" onclick="markAsComplete({{ $material->id }})">
                                <i class="fas fa-check"></i> Tandai Selesai
                            </button>
                        </div>
                        <div class="text-muted small mt-2">
                            <i class="fas fa-info-circle"></i> Klik setelah selesai mempelajari materi ini
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Share -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Bagikan</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard()">
                            <i class="fas fa-copy"></i> Salin Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.content-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.5rem;
    line-height: 1.8;
}

.preview-overlay {
    position: relative;
}

.preview-lock {
    position: absolute;
    top: 60%;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.9) 30%);
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 2rem;
    color: white;
}

.preview-lock h5 {
    color: white;
    font-weight: bold;
}
</style>
@endpush

@push('scripts')
<script>
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(function() {
        alert('Link berhasil disalin!');
    }, function(err) {
        console.error('Gagal menyalin link: ', err);
    });
}

function markAsComplete(materialId) {
    if (confirm('Apakah Anda yakin ingin menandai materi ini sebagai selesai?')) {
        fetch(`/materials/${materialId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to update progress
                location.reload();
            } else {
                alert('Terjadi kesalahan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan progress');
        });
    }
}

function handleVideoError(iframe) {
    // Hide the iframe and show error message
    iframe.style.display = 'none';
    
    // Find the parent container and show error
    const container = iframe.closest('.ratio');
    if (container) {
        container.innerHTML = `
            <div class="alert alert-danger h-100 d-flex align-items-center justify-content-center">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h5>Video Tidak Dapat Dimuat</h5>
                    <p class="mb-3">Video mungkin telah dihapus, bersifat privat, atau tidak tersedia di wilayah Anda.</p>
                    <a href="{{ $material->getYoutubeWatchUrl() }}" target="_blank" class="btn btn-danger">
                        <i class="fab fa-youtube"></i> Buka di YouTube
                    </a>
                </div>
            </div>
        `;
    }
}

function reportVideoIssue(materialId) {
    if (confirm('Apakah Anda ingin melaporkan masalah dengan video ini?')) {
        fetch(`/materials/${materialId}/report-issue`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                issue_type: 'video_unavailable',
                description: 'Video tidak dapat diputar atau tidak tersedia'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Terima kasih! Masalah video telah dilaporkan dan akan segera diperbaiki.');
            } else {
                alert('Gagal melaporkan masalah. Silakan coba lagi nanti.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat melaporkan masalah');
        });
    }
}
</script>
@endpush