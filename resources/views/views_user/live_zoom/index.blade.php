@extends('layouts.user.app')

@section('title', 'Live Zoom Classes')

@section('content')

<section id="live-classes" class="live-classes">
    <div class="container" data-aos="fade-up">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3">Kelas Live Zoom</h2>
            <p class="text-muted">Ikuti kelas live zoom dari paket yang sudah Anda beli</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('user.live-zoom.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Status Kelas</label>
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Paket</label>
                                <select name="package" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ request('package') == 'all' ? 'selected' : '' }}>Semua Paket</option>
                                    @foreach($purchasedPackages as $package)
                                        <option value="{{ $package->id }}" {{ request('package') == $package->id ? 'selected' : '' }}>
                                            {{ $package->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cari</label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari kelas..." value="{{ request('search') }}">
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

    @if($liveClasses->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-video fa-4x text-muted mb-3"></i>
                        <h5>Belum Ada Kelas Live</h5>
                        <p class="text-muted">
                            @if($purchasedPackages->isEmpty())
                                Anda belum membeli paket apapun. Silakan beli paket untuk mengakses kelas live zoom.
                            @else
                                Kelas live untuk paket yang Anda beli belum tersedia atau belum dijadwalkan.
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
        <div class="row">
            @foreach($liveClasses as $liveClass)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 live-class-card">
                        <div class="card-body">
                            <div class="mb-3">
                                <span class="badge {{ $liveClass->getStatusBadgeClass() }}">
                                    {{ ucfirst($liveClass->status) }}
                                </span>
                                @if($liveClass->batch)
                                    <span class="badge bg-secondary">{{ $liveClass->batch->nama }}</span>
                                @endif
                                <span class="badge bg-info">
                                    <i class="{{ $liveClass->getPlatformIcon() }}"></i> {{ ucfirst($liveClass->platform) }}
                                </span>
                            </div>
                            
                            <h5 class="card-title">{{ $liveClass->title }}</h5>
                            
                            <p class="card-text text-muted small">
                                {{ Str::limit($liveClass->description, 100) }}
                            </p>

                            <div class="mb-2">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar text-primary me-2"></i>
                                    <small>{{ $liveClass->scheduled_at->format('d F Y') }}</small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <small>{{ $liveClass->scheduled_at->format('H:i') }} WIB ({{ $liveClass->duration_minutes }} menit)</small>
                                </div>
                                @if($liveClass->tutor)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        <small>{{ $liveClass->tutor->name }}</small>
                                    </div>
                                @endif
                            </div>

                            @if($liveClass->max_participants)
                                <small class="text-muted">
                                    <i class="fas fa-users"></i> Max {{ $liveClass->max_participants }} peserta
                                </small>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('user.live-zoom.show', $liveClass) }}" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-video"></i> 
                                @if($liveClass->status === 'ongoing')
                                    Gabung Sekarang
                                @else
                                    Lihat Detail
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                {{ $liveClasses->links() }}
            </div>
        </div>
    @endif
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

.live-class-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e3e6f0;
}

.live-class-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.card-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.badge {
    font-size: 11px;
    padding: 4px 8px;
}
</style>
@endpush