@extends('layouts/admin/app')

@section('title', 'Quick Add Materials - Tutor')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-file-plus mr-2 text-success"></i>
                    Quick Add Materials
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('tutor.dashboard') }}">
                            <i class="fas fa-home mr-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('tutor.integrated-dashboard') }}">
                            My Courses
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Quick Add Materials</li>
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
        <i class="fas fa-exclamation-circle mr-2"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <strong>Validation Errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('tutor.integrated-dashboard') }}"
           class="btn btn-outline-secondary btn-lg shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i>Back to My Courses
        </a>
    </div>

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Quick Add Materials</h3>
            <p class="text-muted mb-0">
                Add materials directly to your existing courses
            </p>
        </div>
    </div>

    <form id="quickAddForm" method="POST" action="{{ route('tutor.integrated.quick-add.store') }}">
        @csrf

        <!-- Course Selection -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cog mr-2"></i>Course Selection
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Target Course <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-graduation-cap"></i>
                                    </span>
                                </div>
                                <select name="course_id" class="form-control" required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">
                                            {{ $course->nama }} ({{ $course->kategori }} - {{ $course->level }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="form-text text-muted">Select one of your courses to add materials to</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materials List -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Materials to Add
                    </h5>
                    <button type="button" onclick="addMaterial()"
                            class="btn btn-light btn-sm">
                        <i class="fas fa-plus mr-1"></i>Add Material
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="materialsContainer">
                    <!-- Materials will be added here dynamically -->
                </div>

                <!-- Empty State -->
                <div class="text-center py-5" id="emptyState">
                    <div class="mb-4">
                        <i class="fas fa-file-plus fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">No materials added yet</h5>
                    <p class="text-muted mb-4">Click "Add Material" to start adding materials</p>
                    <button type="button" onclick="addMaterial()"
                            class="btn btn-success btn-lg">
                        <i class="fas fa-plus mr-2"></i>Add First Material
                    </button>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Save Materials</h6>
                                <small class="text-muted">
                                    All materials will be added to the selected course with proper ordering
                                </small>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success btn-lg mr-3">
                                    <i class="fas fa-save mr-2"></i>Save All Materials
                                </button>
                                <a href="{{ route('tutor.integrated-dashboard') }}"
                                   class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times mr-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        border: none;
    }

    .form-control {
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
        padding: 0.75rem;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .input-group-text {
        border-radius: 0.5rem 0 0 0.5rem;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }

    .btn {
        border-radius: 0.5rem;
        font-weight: 500;
    }

    .material-item {
        border-left: 4px solid #28a745;
        margin-bottom: 1rem;
    }

    .content-header {
        background: transparent;
        padding: 0;
        margin-bottom: 1.5rem;
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script>
    let materialCounter = 0;

    function addMaterial() {
        // Hide empty state if exists
        const emptyState = document.getElementById('emptyState');
        if (emptyState) {
            emptyState.style.display = 'none';
        }

        const container = document.getElementById('materialsContainer');

        const materialHTML = `
            <div class="card mb-4 material-item" data-material="${materialCounter}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-file mr-2 text-success"></i>
                        Material ${materialCounter + 1}
                    </h6>
                    <button type="button" onclick="removeMaterial(${materialCounter})"
                            class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Material Title <span class="text-danger">*</span></label>
                                <input type="text" name="materials[${materialCounter}][title]"
                                       placeholder="Enter material title"
                                       class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Material Type <span class="text-danger">*</span></label>
                                <select name="materials[${materialCounter}][type]"
                                        class="form-control" required onchange="updateUrlPlaceholder(${materialCounter})">
                                    <option value="">Select Type</option>
                                    <option value="youtube">📺 YouTube Video</option>
                                    <option value="document">📄 PDF Document</option>
                                    <option value="link">🔗 External Link</option>
                                    <option value="video">🎥 Video File</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Content URL <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-link"></i>
                                </span>
                            </div>
                            <input type="url" name="materials[${materialCounter}][content_url]"
                                   id="url-${materialCounter}"
                                   placeholder="Enter content URL"
                                   class="form-control" required>
                        </div>
                        <small class="form-text text-muted" id="url-help-${materialCounter}">
                            Enter the appropriate URL based on material type
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Chapter Title</label>
                                <input type="text" name="materials[${materialCounter}][chapter_title]"
                                       placeholder="Enter chapter title (optional)"
                                       class="form-control">
                                <small class="form-text text-muted">Leave empty to auto-generate</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Chapter Number</label>
                                <input type="number" name="materials[${materialCounter}][chapter_number]"
                                       value="${materialCounter + 1}"
                                       min="1"
                                       class="form-control">
                                <small class="form-text text-muted">Auto-assigned if left empty</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Description</label>
                        <textarea name="materials[${materialCounter}][description]" rows="3"
                                  class="form-control"
                                  placeholder="Describe this material (optional)"></textarea>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', materialHTML);

        // Scroll to new material
        setTimeout(() => {
            const newMaterial = container.lastElementChild;
            newMaterial.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);

        materialCounter++;
    }

    function removeMaterial(materialIndex) {
        if (confirm('Are you sure you want to remove this material?')) {
            const materialElement = document.querySelector(`[data-material="${materialIndex}"]`);
            if (materialElement) {
                materialElement.remove();

                // Show empty state if no materials left
                const materialsContainer = document.getElementById('materialsContainer');
                if (materialsContainer.children.length === 0) {
                    const emptyState = document.getElementById('emptyState');
                    if (emptyState) {
                        emptyState.style.display = 'block';
                    }
                }
            }
        }
    }

    function updateUrlPlaceholder(materialIndex) {
        const select = document.querySelector(`[data-material="${materialIndex}"] select[name="materials[${materialIndex}][type]"]`);
        const input = document.getElementById(`url-${materialIndex}`);
        const help = document.getElementById(`url-help-${materialIndex}`);

        if (select && input && help) {
            const type = select.value;
            let placeholder = '';
            let helpText = '';

            switch(type) {
                case 'youtube':
                    placeholder = 'https://youtube.com/watch?v=VIDEO_ID';
                    helpText = 'Enter YouTube video URL';
                    break;
                case 'document':
                    placeholder = 'https://example.com/document.pdf';
                    helpText = 'Enter direct PDF link';
                    break;
                case 'link':
                    placeholder = 'https://example.com/resource';
                    helpText = 'Enter external resource URL';
                    break;
                case 'video':
                    placeholder = 'https://example.com/video.mp4';
                    helpText = 'Enter video file URL';
                    break;
                default:
                    placeholder = 'Enter content URL';
                    helpText = 'Enter the appropriate URL based on material type';
            }

            input.placeholder = placeholder;
            help.textContent = helpText;
        }
    }

    // Form validation
    document.getElementById('quickAddForm').addEventListener('submit', function(e) {
        const materials = document.querySelectorAll('.material-item');

        // Check if at least one material exists
        if (materials.length === 0) {
            e.preventDefault();
            alert('Please add at least one material before saving.');
            return false;
        }

        // Validate each material
        let isValid = true;
        const errors = [];

        materials.forEach((material, index) => {
            const title = material.querySelector('input[name*="[title]"]').value.trim();
            const type = material.querySelector('select[name*="[type]"]').value;
            const url = material.querySelector('input[name*="[content_url]"]').value.trim();

            if (!title) {
                errors.push(`Material ${index + 1}: Title is required`);
                isValid = false;
            }

            if (!type) {
                errors.push(`Material ${index + 1}: Type is required`);
                isValid = false;
            }

            if (!url) {
                errors.push(`Material ${index + 1}: URL is required`);
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fix the following errors:\n\n' + errors.join('\n'));
            return false;
        }

        // Show loading state
        const submitBtn = document.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving Materials...';
        submitBtn.disabled = true;

        // Store original text to restore if needed
        submitBtn.dataset.originalText = originalText;
    });

    // Initialize with one material
    addMaterial();
</script>
@endpush