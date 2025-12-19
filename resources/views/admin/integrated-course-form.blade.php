@extends('layouts/admin/app')

@section('title', ($course ? 'Edit' : 'Create') . ' Course')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-graduation-cap mr-2 text-primary"></i>
                    {{ $course ? 'Edit Course' : 'Create New Course' }}
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
                    <li class="breadcrumb-item active">{{ $course ? 'Edit' : 'Create' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.integrated-dashboard') }}" 
                   class="btn btn-outline-secondary btn-lg shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
            </div>

            <!-- Page Title -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">{{ $course ? 'Edit Course Details' : 'Create New Course' }}</h3>
                    <p class="text-muted mb-0">
                        {{ $course ? 'Update your course information and materials' : 'Fill in the details to create a new integrated course' }}
                    </p>
                    @if($course)
                        <small class="text-info">
                            <i class="fas fa-info-circle mr-1"></i>
                            Existing materials can be edited individually or removed. New materials will be added with proper ordering.
                        </small>
                    @endif
                </div>
            </div>

            <form id="integratedForm" method="POST" action="{{ route('admin.integrated.store') }}">
                @csrf
                @if($course)
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                @endif

                <!-- Course Information Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle mr-2"></i>Course Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Course Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-graduation-cap"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="course_name" value="{{ $course->nama ?? '' }}" 
                                               class="form-control" placeholder="Enter course name" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Category <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-tag"></i>
                                            </span>
                                        </div>
                                        <select name="category" class="form-control" required>
                                            <option value="">Select Category</option>
                                            <option value="Matematika" {{ ($course->kategori ?? '') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                                            <option value="Fisika" {{ ($course->kategori ?? '') == 'Fisika' ? 'selected' : '' }}>Fisika</option>
                                            <option value="Kimia" {{ ($course->kategori ?? '') == 'Kimia' ? 'selected' : '' }}>Kimia</option>
                                            <option value="Bahasa Indonesia" {{ ($course->kategori ?? '') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                            <option value="Bahasa Inggris" {{ ($course->kategori ?? '') == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                                            <option value="Biologi" {{ ($course->kategori ?? '') == 'Biologi' ? 'selected' : '' }}>Biologi</option>
                                            <option value="Sejarah" {{ ($course->kategori ?? '') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                                            <option value="Geografi" {{ ($course->kategori ?? '') == 'Geografi' ? 'selected' : '' }}>Geografi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Level <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-signal"></i>
                                            </span>
                                        </div>
                                        <select name="level" class="form-control" required>
                                            <option value="">Select Level</option>
                                            <option value="Dasar" {{ ($course->level ?? '') == 'Dasar' ? 'selected' : '' }}>Dasar (Beginner)</option>
                                            <option value="Menengah" {{ ($course->level ?? '') == 'Menengah' ? 'selected' : '' }}>Menengah (Intermediate)</option>
                                            <option value="Lanjut" {{ ($course->level ?? '') == 'Lanjut' ? 'selected' : '' }}>Lanjut (Advanced)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Instructor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user-tie"></i>
                                            </span>
                                        </div>
                                        <select name="tutor_id" class="form-control" required>
                                            <option value="">Select Instructor</option>
                                            @foreach($tutors as $tutor)
                                                <option value="{{ $tutor->id }}" {{ ($course && $tutor->id == ($course->materials->first()->tutor_id ?? '')) ? 'selected' : '' }}>
                                                    {{ $tutor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="font-weight-bold">Course Description <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-align-left"></i>
                                    </span>
                                </div>
                                <textarea id="course_description" name="course_description" rows="4"
                                          class="form-control"
                                          placeholder="Provide a detailed description of your course..." required></textarea>
                            </div>
                            <small class="form-text text-muted">Describe what students will learn in this course</small>
                        </div>
                    </div>
                </div>

                <!-- Chapters and Materials Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list mr-2"></i>Chapters & Materials
                            </h5>
                            <button type="button" onclick="addChapter()" 
                                    class="btn btn-light btn-sm">
                                <i class="fas fa-plus mr-1"></i>Add Chapter
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chaptersContainer">
                            @if($existingChapters->count() > 0)
                                @foreach($existingChapters as $chapterNum => $materials)
                                    <div class="card mb-4 chapter-section border-primary" data-chapter="{{ $loop->index }}">
                                        <!-- Hidden field to track actual chapter number -->
                                        <input type="hidden" name="chapters[{{ $loop->index }}][chapter_number]" value="{{ $chapterNum }}">
                                        
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 font-weight-bold">
                                                <i class="fas fa-book mr-2 text-primary"></i>
                                                Chapter {{ $chapterNum }}: {{ $materials->first()->chapter_title ?? 'Untitled Chapter' }}
                                            </h6>
                                            <button type="button" onclick="removeChapter({{ $loop->index }})"
                                                    class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash mr-1"></i>Remove
                                            </button>
                                        </div>
                                        
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Chapter Title <span class="text-danger">*</span></label>
                                                        <input type="text" name="chapters[{{ $loop->index }}][title]"
                                                               value="{{ $materials->first()->chapter_title }}"
                                                               class="form-control"
                                                               placeholder="Enter chapter title" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Chapter Order</label>
                                                        <input type="number"
                                                               class="form-control"
                                                               value="{{ $chapterNum }}"
                                                               readonly>
                                                        <small class="form-text text-muted">Chapter numbers are preserved</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Chapter Description</label>
                                                        <textarea name="chapters[{{ $loop->index }}][description]" rows="2"
                                                                  class="form-control"
                                                                  placeholder="Brief description of this chapter">{{ $materials->first()->description ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <hr class="my-4">
                                            
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0 font-weight-bold">
                                                    <i class="fas fa-file-alt mr-2 text-info"></i>
                                                    Materials ({{ $materials->count() }})
                                                    <small class="text-muted ml-2">Material ordering is preserved</small>
                                                </h6>
                                                <button type="button" onclick="addMaterial({{ $loop->index }})"
                                                        class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-plus mr-1"></i>Add Material
                                                </button>
                                            </div>
                                            
                                            <div id="materials-{{ $loop->index }}">
                                                @foreach($materials as $material)
                                                    <div class="card mb-3 material-section border-info" data-material="{{ $loop->index }}">
                                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0 font-weight-bold">
                                                                <i class="fas fa-file mr-2 text-info"></i>
                                                                Material {{ $material->material_order }}: {{ $material->title }}
                                                                @if($material->type)
                                                                    <span class="badge badge-secondary ml-2">{{ ucfirst($material->type) }}</span>
                                                                @endif
                                                            </h6>
                                                            <div class="btn-group" role="group">
                                                                <!-- Edit Individual Material -->
                                                                <a href="{{ route('admin.integrated.material.edit', $material->id) }}"
                                                                   class="btn btn-outline-primary btn-sm"
                                                                   title="Edit this material">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <!-- Remove from form (soft delete) -->
                                                                <button type="button" onclick="removeMaterialFromForm({{ $loop->parent->index }}, {{ $loop->index }}, '{{ $material->id }}')"
                                                                        class="btn btn-outline-danger btn-sm"
                                                                        title="Remove from this course">
                                                                    <i class="fas fa-times mr-1"></i>Remove
                                                                </button>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card-body">
                                                            <!-- Hidden field to track existing material ID -->
                                                            <input type="hidden" name="chapters[{{ $loop->parent->index }}][materials][{{ $loop->index }}][id]" value="{{ $material->id }}">
                                                            
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="font-weight-bold">Material Title <span class="text-danger">*</span></label>
                                                                        <input type="text" name="chapters[{{ $loop->parent->index }}][materials][{{ $loop->index }}][title]"
                                                                               value="{{ $material->title }}"
                                                                               class="form-control"
                                                                               placeholder="Enter material title" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="font-weight-bold">Material Type <span class="text-danger">*</span></label>
                                                                        <select name="chapters[{{ $loop->parent->index }}][materials][{{ $loop->index }}][type]"
                                                                                class="form-control" required>
                                                                            <option value="">Select Type</option>
                                                                            <option value="youtube" {{ $material->type == 'youtube' ? 'selected' : '' }}>📺 YouTube Video</option>
                                                                            <option value="document" {{ $material->type == 'document' ? 'selected' : '' }}>📄 PDF Document</option>
                                                                            <option value="link" {{ $material->type == 'link' ? 'selected' : '' }}>🔗 External Link</option>
                                                                            <option value="video" {{ $material->type == 'video' ? 'selected' : '' }}>🎥 Video File</option>
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
                                                                    <input type="url" name="chapters[{{ $loop->parent->index }}][materials][{{ $loop->index }}][content_url]"
                                                                           value="{{ $material->youtube_url ?: $material->file_path ?: $material->external_link }}"
                                                                           placeholder="Enter YouTube URL, PDF link, or external link"
                                                                           class="form-control" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">Material Description</label>
                                                                <textarea name="chapters[{{ $loop->parent->index }}][materials][{{ $loop->index }}][description]" rows="3"
                                                                          class="form-control"
                                                                          placeholder="Describe this material...">{{ $material->description }}</textarea>
                                                            </div>
                                                            
                                                            <!-- Material Info -->
                                                            <div class="alert alert-info">
                                                                <small>
                                                                    <i class="fas fa-info-circle mr-1"></i>
                                                                    <strong>Current Order:</strong> {{ $material->material_order }} |
                                                                    <strong>Type:</strong> {{ ucfirst($material->type) }} |
                                                                    <strong>Tutor:</strong> {{ $material->tutor->name ?? 'N/A' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Empty state for new course -->
                                <div class="text-center py-5" id="emptyState">
                                    <div class="mb-4">
                                        <i class="fas fa-book-open fa-4x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted mb-3">No chapters yet</h5>
                                    <p class="text-muted mb-4">Add your first chapter to start building your course</p>
                                    <button type="button" onclick="addChapter()" 
                                            class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus mr-2"></i>Add First Chapter
                                    </button>
                                </div>
                            @endif
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
                                        <h6 class="mb-1">{{ $course ? 'Update' : 'Create' }} Your Course</h6>
                                        <small class="text-muted">
                                            {{ $course ? 'Existing materials will be preserved. New materials will follow proper ordering.' : 'Review all information before creating your course' }}
                                        </small>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success btn-lg mr-3">
                                            <i class="fas fa-save mr-2"></i>
                                            {{ $course ? 'Update Course' : 'Create Course' }}
                                        </button>
                                        <a href="{{ route('admin.integrated-dashboard') }}" 
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
    </div>
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
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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
    
    .chapter-section {
        border-left: 4px solid #007bff;
    }
    
    .material-section {
        border-left: 4px solid #17a2b8;
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
    let chapterCounter = {{ $existingChapters->count() ?? 0 }};
    let materialCounters = @json($existingChapters->map(function($materials) { return $materials->count(); })->values()->toArray() ?: [0]);

    function addChapter() {
        // Hide empty state if exists
        const emptyState = document.getElementById('emptyState');
        if (emptyState) {
            emptyState.style.display = 'none';
        }

        const container = document.getElementById('chaptersContainer');
        
        const chapterHTML = `
            <div class="card mb-4 chapter-section border-primary" data-chapter="${chapterCounter}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-book mr-2 text-primary"></i>
                        Chapter ${chapterCounter + 1}
                    </h6>
                    <button type="button" onclick="removeChapter(${chapterCounter})"
                            class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="font-weight-bold">Chapter Title <span class="text-danger">*</span></label>
                                <input type="text" name="chapters[${chapterCounter}][title]"
                                       placeholder="Enter chapter title"
                                       class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Chapter Order</label>
                                <input type="number" 
                                       class="form-control" 
                                       value="${chapterCounter + 1}" 
                                       readonly>
                                <small class="form-text text-muted">New chapter</small>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Chapter Description</label>
                                <textarea name="chapters[${chapterCounter}][description]" rows="2"
                                          class="form-control" 
                                          placeholder="Brief description of this chapter"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 font-weight-bold">
                            <i class="fas fa-file-alt mr-2 text-info"></i>
                            Materials
                        </h6>
                        <button type="button" onclick="addMaterial(${chapterCounter})"
                                class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i>Add Material
                        </button>
                    </div>
                    
                    <div id="materials-${chapterCounter}">
                        <!-- Materials will be added here -->
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', chapterHTML);
        
        // Add first material automatically
        addMaterialToChapter(chapterCounter);
        materialCounters[chapterCounter] = 1;
        chapterCounter++;
        
        // Scroll to new chapter
        setTimeout(() => {
            const newChapter = container.lastElementChild;
            newChapter.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }

    function addMaterial(chapterNum) {
        addMaterialToChapter(chapterNum);
    }

    function addMaterialToChapter(chapterNum) {
        const container = document.getElementById(`materials-${chapterNum}`);
        const materialIndex = materialCounters[chapterNum] || 0;
        
        const materialHTML = `
            <div class="card mb-3 material-section border-info" data-material="${materialIndex}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-file mr-2 text-info"></i>
                        Material ${materialIndex + 1} (New)
                    </h6>
                    <button type="button" onclick="removeMaterial(${chapterNum}, ${materialIndex})"
                            class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-times mr-1"></i>Remove
                    </button>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Material Title <span class="text-danger">*</span></label>
                                <input type="text" name="chapters[${chapterNum}][materials][${materialIndex}][title]"
                                       placeholder="Enter material title"
                                       class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Material Type <span class="text-danger">*</span></label>
                                <select name="chapters[${chapterNum}][materials][${materialIndex}][type]"
                                        class="form-control" required>
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
                            <input type="url" name="chapters[${chapterNum}][materials][${materialIndex}][content_url]"
                                   placeholder="Enter YouTube URL, PDF link, or external link"
                                   class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Material Description</label>
                        <textarea name="chapters[${chapterNum}][materials][${materialIndex}][description]" rows="3"
                                  class="form-control" 
                                  placeholder="Describe this material..."></textarea>
                    </div>
                    
                    <div class="alert alert-warning">
                        <small>
                            <i class="fas fa-plus mr-1"></i>
                            <strong>New Material:</strong> Will be added with proper ordering after existing materials.
                        </small>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', materialHTML);
        materialCounters[chapterNum] = materialIndex + 1;
        
        // Scroll to new material
        setTimeout(() => {
            const newMaterial = container.lastElementChild;
            newMaterial.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }

    function removeChapter(chapterNum) {
        if (confirm('Are you sure you want to remove this chapter and all its materials?')) {
            const chapterElement = document.querySelector(`[data-chapter="${chapterNum}"]`);
            if (chapterElement) {
                // Check if this chapter has existing materials (hidden ID fields)
                const materialIdInputs = chapterElement.querySelectorAll('input[name$="[id]"]');
                const hasExistingMaterials = materialIdInputs.length > 0;
                
                if (hasExistingMaterials) {
                    // For existing chapters, mark for deletion instead of removing
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `chapters[${chapterNum}][delete]`;
                    hiddenInput.value = '1';
                    chapterElement.appendChild(hiddenInput);
                    
                    // Hide the chapter element and show deletion notice
                    chapterElement.style.display = 'none';
                    
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger';
                    alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i><strong>Chapter marked for deletion:</strong> This chapter and all its materials will be permanently removed when you save the course.';
                    chapterElement.insertBefore(alertDiv, chapterElement.firstChild);
                    
                    console.log(`Chapter ${chapterNum} with ${materialIdInputs.length} materials marked for deletion`);
                } else {
                    // For new chapters, simply remove from DOM
                    chapterElement.remove();
                    
                    // Show empty state if no chapters left
                    const chaptersContainer = document.getElementById('chaptersContainer');
                    if (chaptersContainer.children.length === 0) {
                        const emptyState = document.getElementById('emptyState');
                        if (emptyState) {
                            emptyState.style.display = 'block';
                        }
                    }
                    
                    console.log(`New Chapter ${chapterNum} removed from DOM`);
                }
            }
        }
    }

    function removeMaterial(chapterNum, materialNum) {
        if (confirm('Are you sure you want to remove this material?')) {
            const materialElement = document.querySelector(`[data-chapter="${chapterNum}"] [data-material="${materialNum}"]`);
            if (materialElement) {
                materialElement.remove();
            }
        }
    }

    // New function to handle removal of existing materials from form
    function removeMaterialFromForm(chapterNum, materialNum, materialId) {
        if (confirm('Are you sure you want to remove this material from the course? This action cannot be undone.')) {
            const materialElement = document.querySelector(`[data-chapter="${chapterNum}"] [data-material="${materialNum}"]`);
            if (materialElement) {
                // Add hidden field to mark material for deletion
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `chapters[${chapterNum}][materials][${materialNum}][delete]`;
                hiddenInput.value = materialId;
                materialElement.appendChild(hiddenInput);
                
                // Hide the material element
                materialElement.style.display = 'none';
                
                // Show confirmation
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger';
                alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i><strong>Material marked for deletion:</strong> This material will be permanently removed when you save the course.';
                materialElement.insertBefore(alertDiv, materialElement.firstChild);
            }
        }
    }

    // Form validation
    document.getElementById('integratedForm').addEventListener('submit', function(e) {
        const chapters = document.querySelectorAll('.chapter-section');
        if (chapters.length === 0) {
            e.preventDefault();
            alert('Please add at least one chapter to your course.');
            return false;
        }
        
        // Show loading state
        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        submitBtn.disabled = true;
    });

    // Initialize with one chapter if no existing chapters
    @if($existingChapters->count() == 0)
        // Don't auto-add, let user decide
    @endif

    // Initialize Summernote for course description
    $('#course_description').summernote({
        height: 150,
        placeholder: 'Provide a detailed description of your course...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Set existing content for editing
    @if($course && $course->deskripsi)
        $('#course_description').summernote('code', '{{ $course->deskripsi }}');
    @endif
</script>
@endpush