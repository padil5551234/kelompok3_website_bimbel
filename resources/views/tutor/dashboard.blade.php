@extends('layouts.admin.app')

@section('title')
    Dashboard Tutor
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-2">
                                <i class="fas fa-chalkboard-teacher"></i> 
                                Selamat Datang, {{ Auth::user()->name }}!
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-calendar-alt mr-1"></i> 
                                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <img src="{{ asset('stisla/img/teacher.svg') }}" alt="Teacher" class="img-fluid" style="max-height: 100px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Classes Card -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-video"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Kelas</h4>
                    </div>
                    <div class="card-body">
                        {{ $stats['total_classes'] }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Classes Card -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Kelas Mendatang</h4>
                    </div>
                    <div class="card-body">
                        {{ $stats['upcoming_classes'] }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Classes Card -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Kelas Selesai</h4>
                    </div>
                    <div class="card-body">
                        {{ $stats['completed_classes'] }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Materials Card -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-book"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Materi</h4>
                    </div>
                    <div class="card-body">
                        {{ $stats['total_materials'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="row mb-4">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-line"></i> Statistik Materi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="media">
                                <div class="media-icon bg-success">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div class="media-body">
                                    <div class="media-title">Materi Publik</div>
                                    <div class="media-value">{{ $stats['public_materials'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="media">
                                <div class="media-icon bg-warning">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="media-body">
                                    <div class="media-title">Total Views</div>
                                    <div class="media-value">{{ number_format($stats['total_views']) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
            <div class="card gradient-bottom">
                <div class="card-header">
                    <h4><i class="fas fa-info-circle"></i> Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <a href="{{ route('tutor.live-classes.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus-circle"></i> Buat Kelas Baru
                            </a>
                        </div>
                        <div class="col-6 mb-2">
                            <a href="{{ route('tutor.integrated.create') }}" class="btn btn-info btn-block">
                                <i class="fas fa-graduation-cap"></i> Buat Course
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('tutor.integrated.quick-add') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-plus-circle"></i> Tambah Materi
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('tutor.integrated-dashboard') }}" class="btn btn-success btn-block">
                                <i class="fas fa-folder"></i> Kelola Course
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Upcoming Classes -->
        <div class="col-lg-7 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-calendar-alt"></i> Kelas Mendatang</h4>
                    <div class="card-header-action">
                        <a href="{{ route('tutor.live-classes.index') }}" class="btn btn-primary">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($upcomingClasses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Judul Kelas</th>
                                        <th>Tanggal & Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingClasses as $class)
                                    <tr>
                                        <td>
                                            <strong>{{ $class->title }}</strong>
                                            @if($class->batch_id)
                                                <br><small class="text-muted">
                                                    <i class="fas fa-users"></i> Batch: {{ $class->batch->nama_paket ?? 'N/A' }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar"></i> 
                                            {{ \Carbon\Carbon::parse($class->scheduled_at)->format('d M Y') }}
                                            <br>
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($class->scheduled_at)->format('H:i') }}
                                        </td>
                                        <td>
                                            @if($class->status == 'scheduled')
                                                <span class="badge badge-warning">Terjadwal</span>
                                            @elseif($class->status == 'ongoing')
                                                <span class="badge badge-success">Berlangsung</span>
                                            @elseif($class->status == 'completed')
                                                <span class="badge badge-info">Selesai</span>
                                            @else
                                                <span class="badge badge-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('tutor.live-classes.show', $class->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               data-toggle="tooltip" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($class->status == 'scheduled')
                                                <a href="{{ route('tutor.live-classes.edit', $class->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   data-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state" style="padding: 40px;">
                            <div class="empty-state-icon">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <h2>Tidak Ada Kelas Mendatang</h2>
                            <p class="lead">
                                Belum ada kelas yang dijadwalkan. Buat kelas baru untuk memulai.
                            </p>
                            <a href="{{ route('tutor.live-classes.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus-circle"></i> Buat Kelas Baru
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Materials -->
        <div class="col-lg-5 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-file-alt"></i> Materi Terbaru</h4>
                    <div class="card-header-action">
                        <a href="{{ route('tutor.materials.index') }}" class="btn btn-primary">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentMaterials->count() > 0)
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach($recentMaterials as $material)
                            <li class="media">
                                <div class="media-icon bg-primary">
                                    @if($material->type == 'video')
                                        <i class="fas fa-video"></i>
                                    @elseif($material->type == 'document')
                                        <i class="fas fa-file-pdf"></i>
                                    @else
                                        <i class="fas fa-link"></i>
                                    @endif
                                </div>
                                <div class="media-body">
                                    <div class="float-right">
                                        @if($material->is_public)
                                            <span class="badge badge-success">Publik</span>
                                        @else
                                            <span class="badge badge-secondary">Private</span>
                                        @endif
                                    </div>
                                    <div class="media-title">
                                        <a href="{{ route('tutor.materials.show', $material->id) }}">
                                            {{ Str::limit($material->title, 40) }}
                                        </a>
                                    </div>
                                    <div class="text-small text-muted">
                                        <i class="fas fa-calendar"></i> 
                                        {{ \Carbon\Carbon::parse($material->created_at)->diffForHumans() }}
                                        <div class="bullet"></div>
                                        <i class="fas fa-eye"></i> {{ $material->views_count ?? 0 }} views
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="empty-state" style="padding: 40px;">
                            <div class="empty-state-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h5>Belum Ada Materi</h5>
                            <p class="text-muted">
                                Upload materi pembelajaran untuk siswa.
                            </p>
                            <a href="{{ route('tutor.materials.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-upload"></i> Upload Materi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tips Section -->
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4><i class="fas fa-lightbulb"></i> Tips untuk Tutor</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <div class="rounded-circle bg-primary p-3">
                                        <i class="fas fa-clock fa-2x text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold">Jadwal Konsisten</h6>
                                    <p class="text-muted small mb-0">
                                        Buat jadwal kelas yang konsisten agar siswa dapat mengikuti dengan teratur.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <div class="rounded-circle bg-success p-3">
                                        <i class="fas fa-comments fa-2x text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold">Interaksi Aktif</h6>
                                    <p class="text-muted small mb-0">
                                        Dorong siswa untuk bertanya dan berpartisipasi aktif dalam kelas.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <div class="rounded-circle bg-info p-3">
                                        <i class="fas fa-file-alt fa-2x text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold">Materi Lengkap</h6>
                                    <p class="text-muted small mb-0">
                                        Upload materi pembelajaran yang lengkap dan terstruktur dengan baik.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-statistic-1 {
        background: #fff;
        box-shadow: 0 2px 6px #acb5f6;
        border-radius: 5px;
        display: flex;
        align-items: center;
        padding: 0;
        transition: all 0.3s ease;
    }

    .card-statistic-1:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(172, 181, 246, 0.4);
    }
    
    .card-statistic-1 .card-icon {
        width: 80px;
        height: 80px;
        margin: 15px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        color: #fff;
        flex-shrink: 0;
    }
    
    .card-statistic-1 .card-wrap {
        padding: 20px;
        flex: 1;
    }
    
    .card-statistic-1 .card-header h4 {
        font-weight: 600;
        font-size: 13px;
        letter-spacing: .5px;
        margin-bottom: 0;
        color: #6c757d;
    }
    
    .card-statistic-1 .card-body {
        font-size: 26px;
        font-weight: 700;
        color: #34395e;
        margin-top: 5px;
    }

    .media-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .media-title {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .media-value {
        font-size: 24px;
        font-weight: 700;
        color: #34395e;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state-icon {
        font-size: 80px;
        color: #dfe6e9;
        margin-bottom: 20px;
    }

    .gradient-bottom {
        background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(109,122,241,0.1) 100%);
    }

    .list-unstyled-border li {
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .list-unstyled-border li:last-child {
        border-bottom: none;
    }

    .text-small {
        font-size: 12px;
    }

    .bullet {
        display: inline-block;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background-color: #6c757d;
        vertical-align: middle;
        margin: 0 8px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-statistic-1 {
            margin-bottom: 15px;
        }

        .card-statistic-1 .card-icon {
            width: 60px;
            height: 60px;
            font-size: 24px;
            margin: 10px;
        }

        .card-statistic-1 .card-wrap {
            padding: 15px;
        }

        .card-statistic-1 .card-body {
            font-size: 20px;
        }

        .media-value {
            font-size: 20px;
        }

        .empty-state-icon {
            font-size: 60px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        h3 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .card-statistic-1 .card-header h4 {
            font-size: 11px;
        }

        .card-statistic-1 .card-body {
            font-size: 18px;
        }

        .btn-block {
            margin-bottom: 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Add animation to statistics cards
        $('.card-statistic-1').each(function(i) {
            $(this).css('opacity', '0');
            $(this).delay(100 * i).animate({
                opacity: 1
            }, 500);
        });
    });
</script>
@endpush