@extends('layouts.user')

@section('title', $lesson->title)

@section('styles')
<style>
    .lesson-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .lesson-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .lesson-header::before {
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
    
    .lesson-breadcrumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        padding: 0.5rem 1rem;
        margin-bottom: 1rem;
        display: inline-block;
    }
    
    .lesson-breadcrumb a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
    }
    
    .lesson-breadcrumb a:hover {
        color: white;
    }
    
    .lesson-type-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .lesson-content {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .video-container {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        background: #000;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .video-container iframe,
    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    .content-section {
        padding: 2rem;
    }
    
    .content-text {
        line-height: 1.8;
        color: #495057;
    }
    
    .content-text h1, .content-text h2, .content-text h3 {
        color: #212529;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    
    .content-text p {
        margin-bottom: 1.5rem;
    }
    
    .content-text ul, .content-text ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    
    .content-text li {
        margin-bottom: 0.5rem;
    }
    
    .lesson-sidebar {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        height: fit-content;
        position: sticky;
        top: 2rem;
    }
    
    .sidebar-section {
        margin-bottom: 2rem;
    }
    
    .sidebar-section:last-child {
        margin-bottom: 0;
    }
    
    .sidebar-title {
        font-weight: 600;
        color: #495057;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .lesson-meta-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #dee2e6;
    }
    
    .lesson-meta-item:last-child {
        border-bottom: none;
    }
    
    .lesson-meta-label {
        font-weight: 500;
        color: #6c757d;
    }
    
    .lesson-meta-value {
        font-weight: 600;
        color: #495057;
    }
    
    .progress-indicator {
        background: #e9ecef;
        border-radius: 10px;
        height: 8px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }
    
    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #28a745, #20c997);
        border-radius: 10px;
        transition: width 0.3s ease;
        width: 0%;
    }
    
    .lesson-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 2rem;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }
    
    .nav-button {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .nav-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .nav-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    .btn-primary-nav {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-secondary-nav {
        background: #6c757d;
        color: white;
    }
    
    .quiz-container {
        background: white;
        border-radius: 8px;
        padding: 2rem;
        margin-top: 2rem;
    }
    
    .question-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #007bff;
    }
    
    .question-text {
        font-weight: 600;
        margin-bottom: 1rem;
        color: #212529;
    }
    
    .answer-option {
        display: block;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .answer-option:hover {
        border-color: #007bff;
        background: #f8f9ff;
    }
    
    .answer-option input[type="radio"] {
        margin-right: 0.75rem;
    }
    
    .exercise-container {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .exercise-title {
        font-weight: 600;
        color: #856404;
        margin-bottom: 1rem;
    }
    
    .document-preview {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        margin-top: 2rem;
    }
    
    .document-icon {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
    
    .interactive-content {
        background: #e3f2fd;
        border: 1px solid #bbdefb;
        border-radius: 8px;
        padding: 2rem;
        margin-top: 2rem;
        text-align: center;
    }
    
    .interactive-placeholder {
        font-size: 2rem;
        color: #1976d2;
        margin-bottom: 1rem;
    }
    
    @media (max-width: 768px) {
        .lesson-header {
            padding: 1.5rem 0;
        }
        
        .content-section {
            padding: 1.5rem;
        }
        
        .lesson-sidebar {
            position: static;
            margin-top: 2rem;
        }
        
        .lesson-navigation {
            flex-direction: column;
            gap: 1rem;
            padding: 1rem;
        }
        
        .nav-button {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="lesson-header">
    <div class="container">
        <div class="lesson-container">
            <!-- Breadcrumb -->
            <div class="lesson-breadcrumb">
                <a href="{{ route('learning-modules.index') }}">Modul Pembelajaran</a>
                <span class="mx-2">/</span>
                <a href="{{ route('learning-modules.show', $lesson->section->learningModule) }}">
                    {{ Str::limit($lesson->section->learningModule->title, 30) }}
                </a>
                <span class="mx-2">/</span>
                <a href="{{ route('learning-modules.section', $lesson->section) }}">
                    {{ Str::limit($lesson->section->title, 30) }}
                </a>
                <span class="mx-2">/</span>
                <span>{{ Str::limit($lesson->title, 30) }}</span>
            </div>
            
            <!-- Lesson Type Indicator -->
            <div class="lesson-type-indicator">
                @switch($lesson->lesson_type)
                    @case('video')
                        <i class="fas fa-play-circle"></i>
                        <span>Video Pembelajaran</span>
                        @break
                    @case('text')
                        <i class="fas fa-file-text"></i>
                        <span>Materi Teks</span>
                        @break
                    @case('quiz')
                        <i class="fas fa-question-circle"></i>
                        <span>Kuis</span>
                        @break
                    @case('exercise')
                        <i class="fas fa-edit"></i>
                        <span>Latihan</span>
                        @break
                    @case('interactive')
                        <i class="fas fa-mouse-pointer"></i>
                        <span>Konten Interaktif</span>
                        @break
                    @case('document')
                        <i class="fas fa-file-alt"></i>
                        <span>Dokumen</span>
                        @break
                    @default
                        <i class="fas fa-book"></i>
                        <span>Materi</span>
                @endswitch
                @if($lesson->is_mandatory)
                    <span class="badge bg-warning text-dark">Wajib</span>
                @else
                    <span class="badge bg-secondary">Opsional</span>
                @endif
            </div>
            
            <!-- Lesson Title -->
            <h1 class="display-6 fw-bold mb-2">{{ $lesson->title }}</h1>
            @if($lesson->subtitle)
                <h2 class="h5 opacity-90 mb-3">{{ $lesson->subtitle }}</h2>
            @endif
            
            <!-- Lesson Meta -->
            <div class="d-flex flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-clock me-2"></i>
                    <span>{{ $lesson->estimated_duration ?? 0 }} menit</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-eye me-2"></i>
                    <span>{{ $lesson->views_count }} views</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-layer-group me-2"></i>
                    <span>{{ $lesson->section->title }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="lesson-container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="lesson-content">
                    <!-- Video Content -->
                    @if($lesson->lesson_type === 'video' && $lesson->video_url)
                        <div class="content-section">
                            <div class="video-container">
                                @if(strpos($lesson->video_url, 'youtube.com') !== false || strpos($lesson->video_url, 'youtu.be') !== false)
                                    @php
                                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $lesson->video_url, $match);
                                        $youtube_id = $match[1] ?? '';
                                    @endphp
                                    @if($youtube_id)
                                        <iframe src="https://www.youtube.com/embed/{{ $youtube_id }}" 
                                                frameborder="0" allowfullscreen>
                                        </iframe>
                                    @else
                                        <iframe src="{{ $lesson->video_url }}" 
                                                frameborder="0" allowfullscreen>
                                        </iframe>
                                    @endif
                                @else
                                    <video controls>
                                        <source src="{{ $lesson->video_url }}" type="video/mp4">
                                        Browser Anda tidak mendukung video HTML5.
                                    </video>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <!-- Text Content -->
                    @if($lesson->content)
                        <div class="content-section">
                            <div class="content-text">
                                {!! $lesson->content !!}
                            </div>
                        </div>
                    @endif
                    
                    <!-- Quiz Content -->
                    @if($lesson->lesson_type === 'quiz' && $lesson->quiz_data)
                        <div class="quiz-container">
                            <h4 class="mb-4">
                                <i class="fas fa-question-circle me-2"></i>
                                {{ $lesson->title }}
                            </h4>
                            @if(isset($lesson->quiz_data['questions']))
                                <p class="text-muted mb-4">
                                    Jumlah soal: {{ $lesson->quiz_data['questions'] }} |
                                    @if(isset($lesson->quiz_data['time_limit']))
                                        Waktu: {{ gmdate('i:s', $lesson->quiz_data['time_limit']) }}
                                    @endif |
                                    @if(isset($lesson->quiz_data['passing_score']))
                                        Nilai minimum: {{ $lesson->quiz_data['passing_score'] }}%
                                    @endif
                                </p>
                                <div class="text-center py-5">
                                    <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Kuis interaktif akan segera tersedia</p>
                                    <button class="btn btn-primary" onclick="startQuiz()">
                                        <i class="fas fa-play me-2"></i>Mulai Kuis
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <!-- Exercise Content -->
                    @if($lesson->lesson_type === 'exercise' && $lesson->exercise_data)
                        <div class="exercise-container">
                            <h5 class="exercise-title">
                                <i class="fas fa-edit me-2"></i>Latihan
                            </h5>
                            <p class="text-muted">Latihan soal akan tersedia dalam mode interaktif.</p>
                            <button class="btn btn-warning" onclick="startExercise()">
                                <i class="fas fa-play me-2"></i>Mulai Latihan
                            </button>
                        </div>
                    @endif
                    
                    <!-- Document Content -->
                    @if($lesson->lesson_type === 'document' && ($lesson->document_path || $lesson->external_link))
                        <div class="document-preview">
                            <div class="document-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <h5 class="mb-3">Dokumen Pembelajaran</h5>
                            <p class="text-muted mb-4">Klik tombol di bawah untuk mengakses dokumen</p>
                            @if($lesson->document_path)
                                <a href="{{ asset('storage/' . $lesson->document_path) }}" 
                                   target="_blank" 
                                   class="btn btn-primary">
                                    <i class="fas fa-download me-2"></i>Unduh Dokumen
                                </a>
                            @elseif($lesson->external_link)
                                <a href="{{ $lesson->external_link }}" 
                                   target="_blank" 
                                   class="btn btn-primary">
                                    <i class="fas fa-external-link-alt me-2"></i>Buka Dokumen
                                </a>
                            @endif
                        </div>
                    @endif
                    
                    <!-- Interactive Content -->
                    @if($lesson->lesson_type === 'interactive' && $lesson->interactive_data)
                        <div class="interactive-content">
                            <div class="interactive-placeholder">
                                <i class="fas fa-mouse-pointer"></i>
                            </div>
                            <h5 class="mb-3">Konten Interaktif</h5>
                            <p class="text-muted mb-4">Konten interaktif akan dimuat di sini</p>
                            <button class="btn btn-info" onclick="startInteractive()">
                                <i class="fas fa-play me-2"></i>Mulai Interaksi
                            </button>
                        </div>
                    @endif
                    
                    <!-- No Content Message -->
                    @if(!$lesson->content && !$lesson->video_url && !$lesson->quiz_data && !$lesson->exercise_data && !$lesson->document_path && !$lesson->interactive_data)
                        <div class="content-section text-center py-5">
                            <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Konten belum tersedia</h4>
                            <p class="text-muted">Materi ini sedang dalam pengembangan</p>
                        </div>
                    @endif
                </div>
                
                <!-- Navigation -->
                <div class="lesson-navigation">
                    <button class="nav-button btn-secondary-nav" onclick="goBack()">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </button>
                    
                    <div class="d-flex gap-2">
                        <button class="nav-button btn-outline-primary" onclick="bookmarkLesson()">
                            <i class="fas fa-bookmark"></i>
                            Bookmark
                        </button>
                        <button class="nav-button btn-outline-success" onclick="markComplete()">
                            <i class="fas fa-check"></i>
                            Tandai Selesai
                        </button>
                    </div>
                    
                    <button class="nav-button btn-primary-nav" onclick="nextLesson()">
                        Selanjutnya
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="lesson-sidebar">
                    <!-- Progress Section -->
                    <div class="sidebar-section">
                        <div class="sidebar-title">Progress Pembelajaran</div>
                        <div class="progress-indicator">
                            <div class="progress-bar" id="lessonProgress"></div>
                        </div>
                        <small class="text-muted">{{ $lesson->completion_rate ?? 0 }}% selesai</small>
                    </div>
                    
                    <!-- Lesson Info -->
                    <div class="sidebar-section">
                        <div class="sidebar-title">Informasi Materi</div>
                        <div class="lesson-meta-item">
                            <span class="lesson-meta-label">Tipe</span>
                            <span class="lesson-meta-value">{{ $lesson->lesson_type_label }}</span>
                        </div>
                        <div class="lesson-meta-item">
                            <span class="lesson-meta-label">Durasi</span>
                            <span class="lesson-meta-value">{{ $lesson->estimated_duration ?? 0 }} menit</span>
                        </div>
                        <div class="lesson-meta-item">
                            <span class="lesson-meta-label">Views</span>
                            <span class="lesson-meta-value">{{ $lesson->views_count }}</span>
                        </div>
                        <div class="lesson-meta-item">
                            <span class="lesson-meta-label">Status</span>
                            <span class="lesson-meta-value">
                                @if($lesson->is_mandatory)
                                    <span class="badge bg-warning text-dark">Wajib</span>
                                @else
                                    <span class="badge bg-secondary">Opsional</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Section Info -->
                    <div class="sidebar-section">
                        <div class="sidebar-title">Informasi Section</div>
                        <div class="lesson-meta-item">
                            <span class="lesson-meta-label">Section</span>
                            <span class="lesson-meta-value">{{ $lesson->section->title }}</span>
                        </div>
                        <div class="lesson-meta-item">
                            <span class="lesson-meta-label">Tipe Section</span>
                            <span class="lesson-meta-value">{{ $lesson->section->section_type_label }}</span>
                        </div>
                        <div class="lesson-meta-item">
                            <span class="lesson-meta-label">Total Materi</span>
                            <span class="lesson-meta-value">{{ $lesson->section->lessons->count() }}</span>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="sidebar-section">
                        <div class="sidebar-title">Aksi</div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('learning-modules.show', $lesson->section->learningModule) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-list me-2"></i>Lihat Semua Materi
                            </a>
                            <button class="btn btn-outline-secondary btn-sm" onclick="downloadNotes()">
                                <i class="fas fa-download me-2"></i>Unduh Catatan
                            </button>
                            <button class="btn btn-outline-info btn-sm" onclick="shareLesson()">
                                <i class="fas fa-share me-2"></i>Bagikan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function goBack() {
    window.history.back();
}

function nextLesson() {
    // Implement navigation to next lesson
    console.log('Navigate to next lesson');
    // You can fetch next lesson from server and redirect
}

function bookmarkLesson() {
    // Implement bookmark functionality
    console.log('Bookmark lesson:', {{ $lesson->id }});
    // Show success message
}

function markComplete() {
    // Implement mark as complete functionality
    console.log('Mark lesson as complete:', {{ $lesson->id }});
    // Update progress bar
    const progressBar = document.getElementById('lessonProgress');
    if (progressBar) {
        progressBar.style.width = '100%';
    }
    // Show success message
}

function startQuiz() {
    console.log('Start quiz for lesson:', {{ $lesson->id }});
    // Implement quiz functionality
}

function startExercise() {
    console.log('Start exercise for lesson:', {{ $lesson->id }});
    // Implement exercise functionality
}

function startInteractive() {
    console.log('Start interactive content for lesson:', {{ $lesson->id }});
    // Implement interactive functionality
}

function downloadNotes() {
    console.log('Download notes for lesson:', {{ $lesson->id }});
    // Implement notes download
}

function shareLesson() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $lesson->title }}',
            text: '{{ $lesson->subtitle ?? $lesson->description ?? "" }}',
            url: window.location.href
        });
    } else {
        // Fallback: copy URL to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link materi telah disalin ke clipboard!');
        });
    }
}

// Initialize progress on page load
document.addEventListener('DOMContentLoaded', function() {
    const progress = {{ $lesson->completion_rate ?? 0 }};
    const progressBar = document.getElementById('lessonProgress');
    if (progressBar) {
        progressBar.style.width = progress + '%';
    }
});

// Auto-save progress
setInterval(function() {
    // Implement auto-save functionality
    console.log('Auto-save progress for lesson:', {{ $lesson->id }});
}, 30000); // Save every 30 seconds
</script>
@endsection