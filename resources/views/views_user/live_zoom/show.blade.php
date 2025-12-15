@extends('layouts.user.app')

@section('title', $liveClass->title)

@section('content')

<section id="live-class-detail" class="live-class-detail">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="badge {{ $liveClass->getStatusBadgeClass() }} me-2">
                                {{ ucfirst($liveClass->status) }}
                            </span>
                            @if($liveClass->batch)
                                <span class="badge bg-secondary me-2">{{ $liveClass->batch->nama }}</span>
                            @endif
                            <span class="badge bg-info">
                                <i class="{{ $liveClass->getPlatformIcon() }}"></i> {{ ucfirst($liveClass->platform) }}
                            </span>
                        </div>

                        <h3 class="mb-3">{{ $liveClass->title }}</h3>

                        <div class="alert alert-info" role="alert">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong><i class="fas fa-calendar"></i> Tanggal:</strong></p>
                                    <p>{{ $liveClass->scheduled_at->format('d F Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong><i class="fas fa-clock"></i> Waktu:</strong></p>
                                    <p>{{ $liveClass->scheduled_at->format('H:i') }} WIB ({{ $liveClass->duration_minutes }} menit)</p>
                                </div>
                            </div>
                        </div>

                        @if($liveClass->description)
                            <div class="mb-4">
                                <h5>Deskripsi Kelas</h5>
                                <p class="text-muted">{!! nl2br(e($liveClass->description)) !!}</p>
                            </div>
                        @endif

                        @if($liveClass->status === 'ongoing' && $liveClass->meeting_link)
                            <div class="alert alert-success mb-4" role="alert">
                                <h5><i class="fas fa-video"></i> Kelas Sedang Berlangsung!</h5>
                                <p>Klik tombol di bawah untuk bergabung ke kelas.</p>
                                <a href="{{ $liveClass->meeting_link }}" target="_blank" class="btn btn-success btn-lg">
                                    <i class="fas fa-video"></i> Gabung Kelas Sekarang
                                </a>
                                @if($liveClass->meeting_password)
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <strong>Meeting Password:</strong> 
                                            <code>{{ $liveClass->meeting_password }}</code>
                                        </small>
                                    </div>
                                @endif
                            </div>
                        @elseif($liveClass->status === 'scheduled')
                            <div class="alert alert-warning" role="alert">
                                <h5><i class="fas fa-clock"></i> Kelas Belum Dimulai</h5>
                                <p>Kelas akan dimulai pada {{ $liveClass->scheduled_at->format('d F Y, H:i') }} WIB.</p>
                                <p class="mb-0">Link meeting akan muncul saat kelas dimulai.</p>
                            </div>
                        @elseif($liveClass->status === 'completed')
                            <div class="alert alert-secondary" role="alert">
                                <h5><i class="fas fa-check-circle"></i> Kelas Telah Selesai</h5>
                                <p class="mb-0">Kelas ini telah selesai pada {{ $liveClass->updated_at->format('d F Y, H:i') }} WIB.</p>
                            </div>
                        @elseif($liveClass->status === 'cancelled')
                            <div class="alert alert-danger" role="alert">
                                <h5><i class="fas fa-times-circle"></i> Kelas Dibatalkan</h5>
                                <p class="mb-0">Mohon maaf, kelas ini telah dibatalkan.</p>
                            </div>
                        @endif

                        @if($liveClass->materials && count($liveClass->materials) > 0)
                            <div class="mb-4">
                                <h5>Materi Kelas</h5>
                                <ul class="list-group">
                                    @foreach($liveClass->materials as $material)
                                        <li class="list-group-item">
                                            <i class="fas fa-file"></i> {{ $material }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Tutor</h5>
                    </div>
                    <div class="card-body">
                        @if($liveClass->tutor)
                            <div class="text-center mb-3">
                                <img src="{{ $liveClass->tutor->profile_photo_url }}" 
                                     alt="{{ $liveClass->tutor->name }}" 
                                     class="rounded-circle"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <h6 class="text-center">{{ $liveClass->tutor->name }}</h6>
                            <p class="text-center text-muted small mb-0">
                                <i class="fas fa-chalkboard-teacher"></i> Tutor
                            </p>
                        @else
                            <p class="text-muted">Informasi tutor belum tersedia</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Detail Kelas</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Platform</small>
                            <p class="mb-0">
                                <i class="{{ $liveClass->getPlatformIcon() }}"></i> 
                                {{ ucfirst($liveClass->platform) }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Durasi</small>
                            <p class="mb-0">{{ $liveClass->duration_minutes }} menit</p>
                        </div>
                        @if($liveClass->max_participants)
                            <div class="mb-3">
                                <small class="text-muted">Kapasitas</small>
                                <p class="mb-0">{{ $liveClass->max_participants }} peserta</p>
                            </div>
                        @endif
                        <div>
                            <small class="text-muted">Paket</small>
                            <p class="mb-0">{{ $liveClass->batch ? $liveClass->batch->nama : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <a href="{{ route('user.live-zoom.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kelas
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
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

.badge {
    font-size: 12px;
    padding: 5px 10px;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e3e6f0;
}
</style>
@endpush