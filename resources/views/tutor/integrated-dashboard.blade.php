@extends('layouts/admin/app')

@section('title', 'Integrated Course Management - Tutor')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-graduation-cap mr-2 text-primary"></i>
                    My Course Materials
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('tutor.dashboard') }}">
                            <i class="fas fa-home mr-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active">My Courses</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 text-dark">Manage Your Course Materials</h4>
                    <p class="text-muted mb-0">Create and organize materials for courses you teach</p>
                </div>
                <div>
                    <a href="{{ route('tutor.integrated.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus mr-2"></i>Create New Course Materials
                    </a>
                    <a href="{{ route('tutor.integrated.quick-add') }}" class="btn btn-outline-success btn-lg ml-2">
                        <i class="fas fa-plus-circle mr-2"></i>Quick Add Materials
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="info-box bg-gradient-info">
                <span class="info-box-icon"><i class="fas fa-graduation-cap"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">My Courses</span>
                    <span class="info-box-number">{{ $courses->count() }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="info-box bg-gradient-success">
                <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">My Materials</span>
                    <span class="info-box-number">{{ $totalMaterials }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $totalMaterials > 0 ? 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="info-box bg-gradient-warning">
                <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Views</span>
                    <span class="info-box-number">{{ \App\Models\Material::where('tutor_id', auth()->id())->sum('views_count') }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Courses I'm Teaching
                    </h3>
                </div>

                <div class="card-body">
                    @if($courses->count() > 0)
                        <div class="table-responsive">
                            <table id="coursesTable" class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th><i class="fas fa-book mr-1"></i>Course</th>
                                        <th><i class="fas fa-tag mr-1"></i>Category</th>
                                        <th><i class="fas fa-signal mr-1"></i>Level</th>
                                        <th><i class="fas fa-file mr-1"></i>My Materials</th>
                                        <th><i class="fas fa-toggle-on mr-1"></i>Status</th>
                                        <th><i class="fas fa-cogs mr-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 font-weight-bold">{{ $course->nama }}</h6>
                                                        <small class="text-muted">{{ Str::limit($course->deskripsi, 80) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-primary badge-lg">
                                                    <i class="fas fa-tag mr-1"></i>{{ $course->kategori }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success badge-lg">
                                                    <i class="fas fa-signal mr-1"></i>{{ $course->level }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-file-alt mr-2 text-info"></i>
                                                    <span class="font-weight-bold">{{ $course->materials_count }}</span>
                                                    <small class="text-muted ml-1">materials</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($course->is_active)
                                                    <span class="badge badge-success badge-lg">
                                                        <i class="fas fa-check mr-1"></i>Active
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger badge-lg">
                                                        <i class="fas fa-times mr-1"></i>Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('tutor.integrated.edit', $course->id) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Edit My Materials">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <a href="{{ route('tutor.integrated.quick-add') }}"
                                                       class="btn btn-sm btn-outline-success"
                                                       title="Add More Materials">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-graduation-cap fa-4x text-muted"></i>
                            </div>
                            <h4 class="text-muted mb-3">No courses found</h4>
                            <p class="text-muted mb-4">You haven't created materials for any courses yet.</p>
                            <a href="{{ route('tutor.integrated.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus mr-2"></i>Create Your First Course Materials
                            </a>
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
    .badge-lg {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }

    .info-box {
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }

    .btn-group .btn {
        border-radius: 0.375rem !important;
        margin: 0 1px;
    }

    .content-header {
        background: transparent;
        padding: 0;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function () {
        $("#coursesTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 10,
            "order": [[ 0, "desc" ]],
            "language": {
                "search": "Search courses:",
                "lengthMenu": "Show _MENU_ courses per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ courses",
                "infoEmpty": "No courses available",
                "infoFiltered": "(filtered from _MAX_ total courses)",
                "emptyTable": "No courses found. Create your first course materials to get started!"
            },
            "buttons": [
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> Copy',
                    className: 'btn btn-secondary btn-sm'
                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    className: 'btn btn-secondary btn-sm'
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-secondary btn-sm'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-secondary btn-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'btn btn-secondary btn-sm'
                },
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-columns"></i> Columns',
                    className: 'btn btn-secondary btn-sm'
                }
            ]
        }).buttons().container().appendTo('#coursesTable_wrapper .col-md-6:eq(0)');
    });
</script>
@endpush