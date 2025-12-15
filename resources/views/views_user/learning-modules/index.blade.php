@extends('layouts.user')

@section('title', 'Modul Pembelajaran')

@section('styles')
<style>
    .module-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }
    
    .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .module-header {
        background: linear-gradient(135deg, var(--module-color, #007bff) 0%, rgba(255, 255, 255, 0.1) 100%);
        color: white;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .module-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(30px, -30px);
    }
    
    .module-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }
    
    .module-content {
        padding: 1.5rem;
    }
    
    .module-stats {
        display: flex;
        gap: 1rem;
        margin: 1rem 0;
        flex-wrap: wrap;
    }
    
    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .stat-item i {
        color: var(--module-color, #007bff);
    }
    
    .difficulty-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .difficulty-beginner {
        background-color: #d4edda;
        color: #155724;
    }
    
    .difficulty-intermediate {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .difficulty-advanced {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .accordion-section {
        margin-top: 1rem;
    }
    
    .section-accordion .accordion-item {
        border: none;
        margin-bottom: 0.5rem;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .section-accordion .accordion-header {
        background: #f8f9fa;
        border: none;
    }
    
    .section-accordion .accordion-button {
        background: transparent;
        border: none;
        font-weight: 600;
        color: #495057;
    }
    
    .section-accordion .accordion-button:not(.collapsed) {
        background: var(--module-color, #007bff);
        color: white;
    }
    
    .lessons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .lesson-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        transition: all 0.2s ease;
    }
    
    .lesson-card:hover {
        border-color: var(--module-color, #007bff);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .lesson-type-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }
    
    .lesson-type-video { background: #dc3545; }
    .lesson-type-text { background: #007bff; }
    .lesson-type-quiz { background: #28a745; }
    .lesson-type-exercise { background: #fd7e14; }
    .lesson-type-interactive { background: #6f42c1; }
    .lesson-type-document { background: #6c757d; }
    
    .filter-tabs {
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 2rem;
    }
    
    .filter-tab {
        border: none;
        background: transparent;
        padding: 1rem 1.5rem;
        color: #6c757d;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }
    
    .filter-tab.active {
        color: var(--module-color, #007bff);
        border-bottom-color: var(--module-color, #007bff);
        background: rgba(0, 123, 255, 0.05);
    }
    
    .search-box {
        border-radius: 25px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        border-color: var(--module-color, #007bff);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    @media (max-width: 768px) {
        .module-stats {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .lessons-grid {
            grid-template-columns: 1fr;
        }
        
        .module-header {
            padding: 1rem;
        }
        
        .module-content {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-2">Modul Pembelajaran</h1>
                    <p class="text-muted mb-0">Pilih modul pembelajaran sesuai kebutuhan Anda</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary fs-6">{{ $modules->total() }} Modul Tersedia</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select class="form-select" id="categoryFilter" onchange="filterModules()">
                                <option value="all">Semua Kategori</option>
                                <option value="SKD" {{ request('category') == 'SKD' ? 'selected' : '' }}>SKD</option>
                                <option value="MATEMATIKA_TERANTUNG" {{ request('category') == 'MATEMATIKA_TERANTUNG' ? 'selected' : '' }}>Matematika Terantung</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Mata Pelajaran</label>
                            <select class="form-select" id="subjectFilter" onchange="filterModules()">
                                <option value="all">Semua Mata Pelajaran</option>
                                <option value="TIU" {{ request('subject') == 'TIU' ? 'selected' : '' }}>TIU</option>
                                <option value="TKP" {{ request('subject') == 'TKP' ? 'selected' : '' }}>TKP</option>
                                <option value="TKA" {{ request('subject') == 'TKA' ? 'selected' : '' }}>TKA</option>
                                <option value="ALJABAR" {{ request('subject') == 'ALJABAR' ? 'selected' : '' }}>Aljabar</option>
                                <option value="GEOMETRI" {{ request('subject') == 'GEOMETRI' ? 'selected' : '' }}>Geometri</option>
                                <option value="TRIGONOMETRI" {{ request('subject') == 'TRIGONOMETRI' ? 'selected' : '' }}>Trigonometri</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Tingkat Kesulitan</label>
                            <select class="form-select" id="difficultyFilter" onchange="filterModules()">
                                <option value="all">Semua Tingkat</option>
                                <option value="beginner" {{ request('difficulty') == 'beginner' ? 'selected' : '' }}>Pemula</option>
                                <option value="intermediate" {{ request('difficulty') == 'intermediate' ? 'selected' : '' }}>Menengah</option>
                                <option value="advanced" {{ request('difficulty') == 'advanced' ? 'selected' : '' }}>Lanjutan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Cari Modul</label>
                            <div class="position-relative">
                                <input type="text" class="form-control search-box" id="searchInput" 
                                       placeholder="Cari modul pembelajaran..." value="{{ request('search') }}"
                                       onkeyup="debounce(filterModules, 500)()">
                                <i class="fas fa-search position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modules Grid -->
    <div class="row">
        <div class="col-12">
            @if($modules->count() > 0)
                <div class="row">
                    @foreach($modules as $module)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="module-card" style="--module-color: {{ $module->color }}">
                                <div class="module-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-grow-1">
                                            <div class="module-icon">
                                                <i class="{{ $module->icon ?? 'fas fa-book' }}"></i>
                                            </div>
                                            <h4 class="h5 mb-2">{{ $module->title }}</h4>
                                            <p class="mb-2 opacity-90">{{ $module->subtitle }}</p>
                                            <div class="difficulty-badge difficulty-{{ $module->difficulty_level }}">
                                                {{ $module->difficulty_level_label }}
                                            </div>
                                        </div>
                                        @if($module->is_featured)
                                            <div class="text-end">
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-star me-1"></i>Unggulan
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="module-content">
                                    <p class="text-muted mb-3">{{ Str::limit($module->description, 120) }}</p>
                                    
                                    <div class="module-stats">
                                        <div class="stat-item">
                                            <i class="fas fa-layer-group"></i>
                                            <span>{{ $module->total_sections }} Section</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-list-check"></i>
                                            <span>{{ $module->total_lessons }} Materi</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ $module->estimated_duration ?? 0 }} menit</span>
                                        </div>
                                        @if($module->is_free)
                                        <div class="stat-item">
                                            <i class="fas fa-gift text-success"></i>
                                            <span class="text-success fw-bold">GRATIS</span>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('learning-modules.show', $module) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye me-2"></i>Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            {{ $modules->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-search fa-3x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">Tidak ada modul ditemukan</h4>
                    <p class="text-muted mb-4">Coba ubah filter atau kata kunci pencarian Anda</p>
                    <a href="{{ route('learning-modules.index') }}" class="btn btn-primary">
                        <i class="fas fa-refresh me-2"></i>Tampilkan Semua Modul
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Loading Spinner -->
<div id="loadingSpinner" class="d-none">
    <div class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Memuat modul pembelajaran...</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let filterTimeout;
    
    function debounce(func, wait) {
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(filterTimeout);
                func(...args);
            };
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(later, wait);
        };
    }
    
    function filterModules() {
        const category = document.getElementById('categoryFilter').value;
        const subject = document.getElementById('subjectFilter').value;
        const difficulty = document.getElementById('difficultyFilter').value;
        const search = document.getElementById('searchInput').value;
        
        // Show loading
        document.getElementById('loadingSpinner').classList.remove('d-none');
        
        // Build URL with parameters
        const params = new URLSearchParams();
        if (category !== 'all') params.append('category', category);
        if (subject !== 'all') params.append('subject', subject);
        if (difficulty !== 'all') params.append('difficulty', difficulty);
        if (search.trim() !== '') params.append('search', search.trim());
        
        const url = params.toString() ? 
            `{{ route('learning-modules.index') }}?${params.toString()}` : 
            `{{ route('learning-modules.index') }}`;
            
        // Redirect to filtered URL
        window.location.href = url;
    }
    
    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Set active filter tabs based on current URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        
        // You can add more initialization here if needed
    });
    
    // Search functionality with Enter key
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            filterModules();
        }
    });
</script>
@endsection