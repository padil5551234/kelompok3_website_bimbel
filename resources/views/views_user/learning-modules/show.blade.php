@extends('layouts.user')

@section('title', $learningModule->title)

@section('styles')
<style>
    .module-detail-header {
        background: linear-gradient(135deg, {{ $learningModule->color }} 0%, rgba(255, 255, 255, 0.1) 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .module-detail-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .module-icon-lg {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.9;
    }
    
    .progress-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .progress-circle {
        width: 80px;
        height: 80px;
        position: relative;
    }
    
    .progress-circle svg {
        transform: rotate(-90deg);
    }
    
    .progress-circle .progress-bg {
        fill: none;
        stroke: #e9ecef;
        stroke-width: 8;
    }
    
    .progress-circle .progress-bar {
        fill: none;
        stroke: {{ $learningModule->color }};
        stroke-width: 8;
        stroke-linecap: round;
        transition: stroke-dasharray 0.5s ease-in-out;
    }
    
    .accordion-custom {
        border: none;
    }
    
    .accordion-custom .accordion-item {
        border: none;
        margin-bottom: 1rem;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .accordion-custom .accordion-item:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }
    
    .accordion-custom .accordion-header {
        background: white;
        border: none;
    }
    
    .accordion-custom .accordion-button {
        background: white;
        border: none;
        padding: 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
        color: #495057;
        position: relative;
    }
    
    .accordion-custom .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, {{ $learningModule->color }} 0%, rgba(255, 255, 255, 0.9) 100%);
        color: white;
        box-shadow: none;
    }
    
    .accordion-custom .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23{{ str_replace('#', '', $learningModule->color) }}'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        transition: transform 0.3s ease;
    }
    
    .accordion-custom .accordion-button:not(.collapsed)::after {
        transform: rotate(180deg);
        filter: brightness(0) invert(1);
    }
    
    .accordion-custom .accordion-body {
        padding: 1.5rem;
        background: #f8f9fa;
    }
    
    .section-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: white;
        border-radius: 8px;
    }
    
    .overview-item {
        text-align: center;
        padding: 0.5rem;
    }
    
    .overview-item .icon {
        font-size: 1.5rem;
        color: {{ $learningModule->color }};
        margin-bottom: 0.5rem;
    }
    
    .overview-item .value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #495057;
        margin-bottom: 0.25rem;
    }
    
    .overview-item .label {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .lessons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }
    
    .lesson-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.25rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .lesson-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: {{ $learningModule->color }};
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }
    
    .lesson-card:hover {
        border-color: {{ $learningModule->color }};
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .lesson-card:hover::before {
        transform: scaleY(1);
    }
    
    .lesson-header {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .lesson-type-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .lesson-type-video { background: linear-gradient(135deg, #dc3545, #c82333); }
    .lesson-type-text { background: linear-gradient(135deg, #007bff, #0056b3); }
    .lesson-type-quiz { background: linear-gradient(135deg, #28a745, #1e7e34); }
    .lesson-type-exercise { background: linear-gradient(135deg, #fd7e14, #e8650e); }
    .lesson-type-interactive { background: linear-gradient(135deg, #6f42c1, #5a32a3); }
    .lesson-type-document { background: linear-gradient(135deg, #6c757d, #545b62); }
    
    .lesson-title {
        font-weight: 600;
        font-size: 1rem;
        color: #495057;
        margin-bottom: 0.25rem;
        line-height: 1.4;
    }
    
    .lesson-subtitle {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .lesson-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
    
    .lesson-meta span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .lesson-description {
        font-size: 0.875rem;
        color: #6c757d;
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    
    .lesson-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .btn-lesson {
        flex: 1;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .btn-primary-custom {
        background: {{ $learningModule->color }};
        color: white;
    }
    
    .btn-primary-custom:hover {
        background: rgba({{ hexdec(substr($learningModule->color, 1, 2)) }}, {{ hexdec(substr($learningModule->color, 3, 2)) }}, {{ hexdec(substr($learningModule->color, 5, 2)) }}, 0.9);
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-outline-custom {
        border: 1px solid {{ $learningModule->color }};
        color: {{ $learningModule->color }};
        background: transparent;
    }
    
    .btn-outline-custom:hover {
        background: {{ $learningModule->color }};
        color: white;
    }
    
    .badge-mandatory {
        background: #dc3545;
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-weight: 500;
    }
    
    .badge-optional {
        background: #6c757d;
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-weight: 500;
    }
    
    .learning-objectives {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid {{ $learningModule->color }};
    }
    
    .learning-objectives h6 {
        color: {{ $learningModule->color }};
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .learning-objectives ul {
        margin: 0;
        padding-left: 1.2rem;
    }
    
    .learning-objectives li {
        margin-bottom: 0.5rem;
        color: #495057;
    }
    
    @media (max-width: 768px) {
        .module-detail-header {
            padding: 2rem 0;
        }
        
        .module-icon-lg {
            font-size: 3rem;
        }
        
        .lessons-grid {
            grid-template-columns: 1fr;
        }
        
        .section-overview {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .lesson-header {
            flex-direction: column;
            text-align: center;
        }
        
        .lesson-meta {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<!-- Module Header -->
<div class="module-detail-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="module-icon-lg">
                    <i class="{{ $learningModule->icon ?? 'fas fa-book' }}"></i>
                </div>
                <h1 class="display-5 fw-bold mb-3">{{ $learningModule->title }}</h1>
                <p class="h5 mb-3 opacity-90">{{ $learningModule->subtitle }}</p>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-light text-dark fs-6">{{ $learningModule->category_label }}</span>
                    <span class="badge bg-light text-dark fs-6">{{ $learningModule->subject_label }}</span>
                    <span class="badge difficulty-badge difficulty-{{ $learningModule->difficulty_level }} fs-6">
                        {{ $learningModule->difficulty_level_label }}
                    </span>
                    @if($learningModule->is_featured)
                        <span class="badge bg-warning text-dark fs-6">
                            <i class="fas fa-star me-1"></i>Unggulan
                        </span>
                    @endif
                    @if($learningModule->is_free)
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-gift me-1"></i>GRATIS
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="mb-3">
                    <i class="fas fa-clock me-2"></i>
                    <strong>{{ $learningModule->estimated_duration ?? 0 }} menit</strong>
                </div>
                <div class="mb-3">
                    <i class="fas fa-layer-group me-2"></i>
                    <strong>{{ $learningModule->total_sections }} Section</strong>
                </div>
                <div class="mb-3">
                    <i class="fas fa-list-check me-2"></i>
                    <strong>{{ $learningModule->total_lessons }} Materi</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Learning Objectives -->
    @if($learningModule->learning_objectives)
    <div class="learning-objectives">
        <h6><i class="fas fa-target me-2"></i>Tujuan Pembelajaran</h6>
        <ul>
            @foreach($learningModule->learning_objectives as $objective)
                <li>{{ $objective }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Progress Section -->
    <div class="progress-section">
        <div class="row align-items-center">
            <div class="col-md-3 text-center mb-3 mb-md-0">
                <div class="progress-circle mx-auto">
                    <svg width="80" height="80">
                        <circle class="progress-bg" cx="40" cy="40" r="32"></circle>
                        <circle class="progress-bar" cx="40" cy="40" r="32" 
                                stroke-dasharray="0 201.06" stroke-dashoffset="0"></circle>
                    </svg>
                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                        <div class="fw-bold text-primary">0%</div>
                        <div class="small text-muted">Progress</div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <h5 class="mb-3">Progress Pembelajaran</h5>
                <div class="row">
                    <div class="col-sm-4 text-center mb-2">
                        <div class="fw-bold text-primary">{{ $learningModule->total_sections }}</div>
                        <div class="small text-muted">Total Section</div>
                    </div>
                    <div class="col-sm-4 text-center mb-2">
                        <div class="fw-bold text-success">{{ $learningModule->total_lessons }}</div>
                        <div class="small text-muted">Total Materi</div>
                    </div>
                    <div class="col-sm-4 text-center mb-2">
                        <div class="fw-bold text-info">{{ $learningModule->estimated_duration ?? 0 }}</div>
                        <div class="small text-muted">Menit Belajar</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Module Content with Accordion -->
    @if($learningModule->sections->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="accordion accordion-custom" id="moduleAccordion">
                @foreach($learningModule->sections as $sectionIndex => $section)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $section->id }}">
                        <button class="accordion-button {{ $sectionIndex > 0 ? 'collapsed' : '' }}" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse{{ $section->id }}" 
                                aria-expanded="{{ $sectionIndex === 0 ? 'true' : 'false' }}" 
                                aria-controls="collapse{{ $section->id }}">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="text-start">
                                    <div class="fw-bold">{{ $section->title }}</div>
                                    @if($section->subtitle)
                                        <small class="text-muted">{{ $section->subtitle }}</small>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-light text-dark me-2">{{ $section->lessons->count() }} Materi</span>
                                    <span class="badge bg-light text-dark">{{ $section->estimated_duration ?? 0 }} menit</span>
                                </div>
                            </div>
                        </button>
                    </h2>
                    
                    <div id="collapse{{ $section->id }}" 
                         class="accordion-collapse collapse {{ $sectionIndex === 0 ? 'show' : '' }}" 
                         aria-labelledby="heading{{ $section->id }}" 
                         data-bs-parent="#moduleAccordion">
                        <div class="accordion-body">
                            <!-- Section Overview -->
                            <div class="section-overview">
                                <div class="overview-item">
                                    <div class="icon"><i class="fas fa-list-check"></i></div>
                                    <div class="value">{{ $section->lessons->count() }}</div>
                                    <div class="label">Materi</div>
                                </div>
                                <div class="overview-item">
                                    <div class="icon"><i class="fas fa-clock"></i></div>
                                    <div class="value">{{ $section->estimated_duration ?? 0 }}</div>
                                    <div class="label">Menit</div>
                                </div>
                                <div class="overview-item">
                                    <div class="icon"><i class="fas fa-bookmark"></i></div>
                                    <div class="value">{{ $section->section_type_label }}</div>
                                    <div class="label">Tipe</div>
                                </div>
                            </div>

                            @if($section->description)
                                <p class="text-muted mb-3">{{ $section->description }}</p>
                            @endif

                            <!-- Lessons Grid -->
                            @if($section->lessons->count() > 0)
                                <div class="lessons-grid">
                                    @foreach($section->lessons as $lesson)
                                    <div class="lesson-card">
                                        <div class="lesson-header">
                                            <div class="lesson-type-icon lesson-type-{{ $lesson->lesson_type }}">
                                                @switch($lesson->lesson_type)
                                                    @case('video')
                                                        <i class="fas fa-play"></i>
                                                        @break
                                                    @case('text')
                                                        <i class="fas fa-file-text"></i>
                                                        @break
                                                    @case('quiz')
                                                        <i class="fas fa-question-circle"></i>
                                                        @break
                                                    @case('exercise')
                                                        <i class="fas fa-edit"></i>
                                                        @break
                                                    @case('interactive')
                                                        <i class="fas fa-mouse-pointer"></i>
                                                        @break
                                                    @case('document')
                                                        <i class="fas fa-file-alt"></i>
                                                        @break
                                                    @default
                                                        <i class="fas fa-book"></i>
                                                @endswitch
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="lesson-title">{{ $lesson->title }}</div>
                                                @if($lesson->subtitle)
                                                    <div class="lesson-subtitle">{{ $lesson->subtitle }}</div>
                                                @endif
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    @if($lesson->is_mandatory)
                                                        <span class="badge-mandatory">Wajib</span>
                                                    @else
                                                        <span class="badge-optional">Opsional</span>
                                                    @endif
                                                    <span class="badge bg-light text-dark">{{ $lesson->lesson_type_label }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if($lesson->description)
                                            <div class="lesson-description">
                                                {{ Str::limit($lesson->description, 100) }}
                                            </div>
                                        @endif
                                        
                                        <div class="lesson-meta">
                                            <span><i class="fas fa-clock"></i> {{ $lesson->estimated_duration ?? 0 }} menit</span>
                                            <span><i class="fas fa-eye"></i> {{ $lesson->views_count }} views</span>
                                        </div>
                                        
                                        <div class="lesson-actions">
                                            <a href="{{ route('learning-modules.lesson', $lesson) }}" 
                                               class="btn-lesson btn-primary-custom">
                                                <i class="fas fa-play me-1"></i>Mulai Belajar
                                            </a>
                                            <a href="#" class="btn-lesson btn-outline-custom" 
                                               onclick="previewLesson({{ $lesson->id }})">
                                                <i class="fas fa-eye me-1"></i>Preview
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada materi dalam section ini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted mb-3">Belum ada section dalam modul ini</h4>
                <p class="text-muted">Modul sedang dalam pengembangan</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Navigation -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="{{ route('learning-modules.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Modul
                </a>
                @if($learningModule->sections->count() > 0)
                    <button class="btn btn-primary" onclick="startModule()">
                        <i class="fas fa-play me-2"></i>Mulai Belajar Modul
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function startModule() {
    // Find the first lesson in the first section
    const firstSection = document.querySelector('.accordion-item');
    if (firstSection) {
        const firstLesson = firstSection.querySelector('.btn-lesson.btn-primary-custom');
        if (firstLesson) {
            firstLesson.click();
        }
    }
}

function previewLesson(lessonId) {
    // Implement lesson preview functionality
    console.log('Preview lesson:', lessonId);
    // You can implement modal or preview functionality here
}

// Animate progress circle on page load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        const progressBar = document.querySelector('.progress-bar');
        if (progressBar) {
            const circumference = 2 * Math.PI * 32; // r = 32
            const progress = 0; // Current progress (0%)
            const offset = circumference - (progress / 100) * circumference;
            progressBar.style.strokeDasharray = `${circumference} ${circumference}`;
            progressBar.style.strokeDashoffset = offset;
        }
    }, 500);
});

// Auto-expand first accordion item on load
document.addEventListener('DOMContentLoaded', function() {
    const firstCollapse = document.querySelector('.accordion-collapse.show');
    if (firstCollapse) {
        const firstButton = firstCollapse.previousElementSibling.querySelector('.accordion-button');
        if (firstButton) {
            firstButton.classList.remove('collapsed');
            firstButton.setAttribute('aria-expanded', 'true');
        }
    }
});
</script>
@endsection