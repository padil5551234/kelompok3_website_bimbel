@extends('layouts/admin/app')

@section('title')
Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid dashboard-modern">
    <!-- Statistics Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-primary">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Users</h6>
                        <h2 class="stats-value">{{ $data['user'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-success">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Paket Kedinasan</h6>
                        <h2 class="stats-value">{{ $data['paketUjian'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-info">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Ujian</h6>
                        <h2 class="stats-value">{{ $data['ujian'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-warning">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Ujian Aktif</h6>
                        <h2 class="stats-value">{{ $data['ujianActive'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-danger">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Pembelian</h6>
                        <h2 class="stats-value">{{ $data['pembelian'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-secondary">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Revenue Total</h6>
                        <h2 class="stats-value">Rp {{ number_format($data['revenue'] ?? 0, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Info Section -->
    <div class="row">
        <div class="col-12">
            <div class="card modern-card">
                <div class="card-header modern-card-header">
                    <h4 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Sistem</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="info-box">
                                <i class="fas fa-user-graduate fa-2x text-primary mb-2"></i>
                                <h5>{{ $data['user'] }}</h5>
                                <p class="text-muted mb-0">Peserta Terdaftar</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-box">
                                <i class="fas fa-file-alt fa-2x text-success mb-2"></i>
                                <h5>{{ $data['ujian'] }}</h5>
                                <p class="text-muted mb-0">Total Ujian</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-box">
                                <i class="fas fa-check-circle fa-2x text-warning mb-2"></i>
                                <h5>{{ $data['ujianActive'] }}</h5>
                                <p class="text-muted mb-0">Ujian Berlangsung</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-box">
                                <i class="fas fa-credit-card fa-2x text-danger mb-2"></i>
                                <h5>{{ $data['pembelian'] }}</h5>
                                <p class="text-muted mb-0">Transaksi Sukses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Integrated Course Management Section -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-course">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Courses</h6>
                        <h2 class="stats-value">{{ $data['courses']->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-materials">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Materials</h6>
                        <h2 class="stats-value">{{ $data['totalMaterials'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-tutors">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Tutors</h6>
                        <h2 class="stats-value">{{ $data['totalTutors'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Management Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card modern-card">
                <div class="card-header modern-card-header">
                    <div class="d-flex justify-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-book-open me-2"></i>Integrated Course Management</h4>
                    </div>
                </div>
                <div class="card-body">
                    @if($data['courses']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Course Name</th>
                                        <th>Category</th>
                                        <th>Level</th>
                                        <th>Materials</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['courses']->take(5) as $course)
                                        <tr>
                                            <td>
                                                <strong>{{ $course->nama }}</strong>
                                                <br>
                                                <small class="text-muted">{!! Str::limit($course->deskripsi, 50) !!}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $course->kategori }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">{{ $course->level }}</span>
                                            </td>
                                            <td>
                                                <i class="fas fa-file-alt me-1 text-muted"></i>
                                                {{ $course->materials_count }} materials
                                            </td>
                                            <td>
                                                @if($course->is_active)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check me-1"></i>Active
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-times me-1"></i>Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.integrated.edit', $course->id) }}"
                                                       class="btn btn-outline-primary btn-sm" title="Edit Course">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.integrated.duplicate', $course->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success btn-sm" title="Duplicate Course">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="deleteCourse({{ $course->id }})" title="Delete Course">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($data['courses']->count() > 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.integrated-dashboard') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>View All Courses ({{ $data['courses']->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No courses found</h5>
                            <p class="text-muted">Integrated course management is not available at this time</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard-modern {
        padding: 20px 0;
    }

    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 0;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-card-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stats-card-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .stats-card-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stats-card-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .stats-card-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stats-card-secondary {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    }

    .stats-card-course {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stats-card-materials {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stats-card-tutors {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stats-card-body {
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 2;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        z-index: 1;
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stats-icon i {
        font-size: 28px;
        color: #ffffff;
    }

    .stats-content {
        flex: 1;
        color: #ffffff;
    }

    .stats-label {
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 5px;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stats-value {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .modern-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .modern-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px 15px 0 0;
        padding: 20px 25px;
        border: none;
        color: #ffffff;
    }

    .modern-card-header h4 {
        color: #ffffff;
        margin: 0;
        font-weight: 600;
    }

    .info-box {
        padding: 20px;
        border-radius: 10px;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .info-box:hover {
        background: #e9ecef;
        transform: translateY(-3px);
    }

    .info-box h5 {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin: 10px 0;
    }

    .info-box p {
        font-size: 13px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .stats-card-body {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .stats-value {
            font-size: 28px;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
        }

        .stats-icon i {
            font-size: 24px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Add animation to statistics cards
    $('.stats-card').each(function(i) {
        $(this).css('opacity', '0');
        $(this).delay(100 * i).animate({
            opacity: 1
        }, 500);
    });
});

// Function to delete course
function deleteCourse(courseId) {
    if (confirm('Are you sure you want to delete this course and all its materials? This action cannot be undone.')) {
        // Create a form dynamically and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/integrated/course/${courseId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
