@extends('layouts/admin/app')

@section('title', 'Edit Material')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-edit mr-2 text-primary"></i>
                    Edit Material
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home mr-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.integrated-dashboard') }}">
                            Integrated Course
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Edit Material</li>
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
    <!-- Material Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-info-circle mr-2"></i>Material Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Course:</strong> {{ $material->batch->nama ?? 'N/A' }}<br>
                            <strong>Chapter:</strong> {{ $material->chapter_title }}<br>
                            <strong>Current Order:</strong> {{ $material->material_order }}
                        </div>
                        <div class="col-md-6">
                            <strong>Type:</strong> <span class="badge badge-primary">{{ ucfirst($material->type) }}</span><br>
                            <strong>Tutor:</strong> {{ $material->tutor->name ?? 'N/A' }}<br>
                            <strong>Subject:</strong> {{ $material->mapel }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit mr-2"></i>Edit Material Details
                    </h3>
                </div>
                
                <form method="POST" action="{{ route('admin.integrated.material.update', $material->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="control-label">Material Title <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $material->title) }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" class="control-label">Material Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('type') is-invalid @enderror" 
                                            id="type" 
                                            name="type" 
                                            required>
                                        <option value="">Select Type</option>
                                        <option value="youtube" {{ old('type', $material->type) == 'youtube' ? 'selected' : '' }}>YouTube Video</option>
                                        <option value="document" {{ old('type', $material->type) == 'document' ? 'selected' : '' }}>Document/PDF</option>
                                        <option value="link" {{ old('type', $material->type) == 'link' ? 'selected' : '' }}>External Link</option>
                                        <option value="video" {{ old('type', $material->type) == 'video' ? 'selected' : '' }}>Video File</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tutor_id" class="control-label">Tutor <span class="text-danger">*</span></label>
                                    <select class="form-control @error('tutor_id') is-invalid @enderror" 
                                            id="tutor_id" 
                                            name="tutor_id" 
                                            required>
                                        <option value="">Select Tutor</option>
                                        @foreach($tutors as $tutor)
                                            <option value="{{ $tutor->id }}" 
                                                    {{ old('tutor_id', $material->tutor_id) == $tutor->id ? 'selected' : '' }}>
                                                {{ $tutor->name }} ({{ $tutor->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tutor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="content_url" class="control-label">Content URL/Path <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('content_url') is-invalid @enderror" 
                                           id="content_url" 
                                           name="content_url" 
                                           value="{{ old('content_url', $material->youtube_url ?: $material->file_path ?: $material->external_link) }}" 
                                           placeholder="YouTube URL, file path, or external link"
                                           required>
                                    @error('content_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        For YouTube: full URL (https://youtube.com/watch?v=...)<br>
                                        For documents: file path or URL<br>
                                        For links: full URL
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" class="control-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Material description...">{{ old('description', $material->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('admin.integrated.edit', $material->batch_id) }}" 
                                   class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-2"></i>Back to Course
                                </a>
                                
                                <form method="POST" 
                                      action="{{ route('admin.integrated.material.delete', $material->id) }}" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this material? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash mr-2"></i>Delete Material
                                    </button>
                                </form>
                            </div>
                            
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>Update Material
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }
    
    .form-group.required .control-label:after {
        content:" *";
        color:red;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function () {
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // Type change handler untuk show/hide guidance
        $('#type').change(function() {
            var type = $(this).val();
            var urlField = $('#content_url');
            var helpText = urlField.siblings('.form-text');
            
            if (type === 'youtube') {
                helpText.html('For YouTube: full URL (https://youtube.com/watch?v=...)<br>For documents: file path or URL<br>For links: full URL').show();
            } else if (type === 'document') {
                helpText.html('Enter the file path or URL to the document/PDF file').show();
            } else if (type === 'link') {
                helpText.html('Enter the full external URL').show();
            } else if (type === 'video') {
                helpText.html('Enter the file path or URL to the video file').show();
            }
        });
    });
</script>
@endpush