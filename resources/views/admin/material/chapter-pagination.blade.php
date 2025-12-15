@extends('layouts/admin/app')

@section('title', 'Course Chapter Management')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-list-ol mr-2 text-primary"></i>
                    Course Chapter Management
                </h1>
                <p class="text-muted mb-0">Track and manage chapters across all integrated courses</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.integrated-dashboard') }}">Courses</a></li>
                    <li class="breadcrumb-item active">Course Chapters</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $totalChapters }}</h3>
                            <p class="mb-0">Total Chapters</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-list-ol fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $totalMaterials }}</h3>
                            <p class="mb-0">Total Materials</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $totalBatches }}</h3>
                            <p class="mb-0">Active Batches</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-graduation-cap fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $totalMaterials > 0 ? round($totalMaterials / $totalChapters, 1) : 0 }}</h3>
                            <p class="mb-0">Avg Materials/Chapter</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calculator fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chapter Distribution by Batch -->
    @if(count($batchChapterStats) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar mr-2"></i>Chapter Distribution by Batch
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($batchChapterStats as $batchName => $chapterCount)
                        <div class="col-md-4 mb-3">
                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                <div>
                                    <h6 class="mb-1">{{ $batchName }}</h6>
                                    <small class="text-muted">{{ $chapterCount }} chapter(s)</small>
                                </div>
                                <div class="text-right">
                                    <span class="badge badge-primary badge-lg">{{ $chapterCount }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Chapters List with Pagination -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-book mr-2"></i>Chapters List
                    <span class="badge badge-secondary ml-2">{{ $paginatedChapters->total() }} total chapters</span>
                </h5>
                <div>
                    <a href="{{ route('admin.integrated-dashboard') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Courses
                    </a>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="refreshChapterStats()">
                        <i class="fas fa-sync-alt mr-1"></i>Refresh Stats
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="renumberAllChapters()">
                        <i class="fas fa-sort-numeric-down mr-1"></i>Renumber All
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($paginatedChapters->count() > 0)
                <div class="row">
                    @foreach($paginatedChapters as $chapter)
                    <div class="col-md-6 col-lg-4 mb-4" data-batch-id="{{ $chapter['batch_id'] }}">
                        <div class="card border-left-primary h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-bookmark mr-1 text-primary"></i>
                                        Chapter {{ $chapter['chapter_number'] }}
                                    </h6>
                                    <span class="badge badge-primary">{{ $chapter['material_count'] }} materials</span>
                                </div>
                                
                                <h6 class="text-muted mb-2">{{ $chapter['batch_name'] }}</h6>
                                
                                <p class="card-text small mb-3">
                                    <strong>Title:</strong> {{ $chapter['chapter_title'] }}
                                </p>
                                
                                <!-- Material Types Summary -->
                                @php
                                    $materialTypes = [
                                        'youtube' => 0,
                                        'video' => 0,
                                        'document' => 0,
                                        'link' => 0,
                                        'other' => 0
                                    ];
                                    
                                    foreach($chapter['materials'] as $material) {
                                        if(isset($materialTypes[$material->type])) {
                                            $materialTypes[$material->type]++;
                                        } else {
                                            $materialTypes['other']++;
                                        }
                                    }
                                @endphp
                                
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Material Types:</small>
                                    <div class="d-flex flex-wrap gap-1">
                                        @if($materialTypes['youtube'] > 0)
                                            <span class="badge badge-danger badge-sm">
                                                <i class="fab fa-youtube mr-1"></i>{{ $materialTypes['youtube'] }} YouTube
                                            </span>
                                        @endif
                                        @if($materialTypes['video'] > 0)
                                            <span class="badge badge-dark badge-sm">
                                                <i class="fas fa-video mr-1"></i>{{ $materialTypes['video'] }} Video
                                            </span>
                                        @endif
                                        @if($materialTypes['document'] > 0)
                                            <span class="badge badge-primary badge-sm">
                                                <i class="fas fa-file-pdf mr-1"></i>{{ $materialTypes['document'] }} Document
                                            </span>
                                        @endif
                                        @if($materialTypes['link'] > 0)
                                            <span class="badge badge-info badge-sm">
                                                <i class="fas fa-link mr-1"></i>{{ $materialTypes['link'] }} Link
                                            </span>
                                        @endif
                                        @if($materialTypes['other'] > 0)
                                            <span class="badge badge-secondary badge-sm">
                                                <i class="fas fa-file mr-1"></i>{{ $materialTypes['other'] }} Other
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Recent Materials -->
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Recent Materials:</small>
                                    @foreach(collect($chapter['materials'])->take(3) as $material)
                                        <div class="small text-truncate" title="{{ $material->title }}">
                                            <i class="fas fa-file-alt mr-1 text-muted"></i>
                                            {{ Str::limit($material->title, 30) }}
                                        </div>
                                    @endforeach
                                    @if(count($chapter['materials']) > 3)
                                        <small class="text-muted">... and {{ count($chapter['materials']) - 3 }} more</small>
                                    @endif
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $chapter['created_at']->format('d/m/Y') }}
                                    </small>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.integrated.edit', $chapter['batch_id']) }}?chapter={{ $chapter['chapter_number'] }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm delete-chapter-btn" 
                                                data-batch-id="{{ $chapter['batch_id'] }}" 
                                                data-chapter-number="{{ $chapter['chapter_number'] }}" 
                                                data-chapter-name="{{ $chapter['batch_name'] }} - Chapter {{ $chapter['chapter_number'] }}">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    Showing {{ $paginatedChapters->firstItem() ?? 0 }} to {{ $paginatedChapters->lastItem() ?? 0 }}
                                    of {{ $paginatedChapters->total() }} chapters
                                </small>
                            </div>
                            <div>
                                {{ $paginatedChapters->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No course chapters found</h5>
                    <p class="text-muted mb-4">Integrated course management is not available at this time</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function refreshChapterStats() {
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Refreshing...';
    button.disabled = true;
    
    // Refresh the page
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function deleteChapter(batchId, chapterNumber, chapterName) {
    if (confirm(`Are you sure you want to delete "${chapterName}"?\n\nThis will:\n- Delete all materials in this chapter\n- Renumber all subsequent chapters\n- This action cannot be undone!`)) {
        
        console.log('Starting deletion:', { batchId, chapterNumber, chapterName });
        
        // Send delete request with proper error handling
        fetch('{{ route("admin.material.chapter.delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                batch_id: batchId,
                chapter_number: chapterNumber
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                alert(data.message);
                // Force page reload to refresh the chapter list
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            } else {
                alert('Error: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred while deleting the chapter: ' + error.message);
        });
    }
}

function renumberAllChapters() {
    if (confirm('Are you sure you want to renumber all chapters?\n\nThis will:\n- Reset chapter numbering to start from 1\n- Organize chapters in sequential order\n- This action cannot be undone!')) {
        
        console.log('Starting bulk renumbering...');
        
        // Show loading state on the clicked button
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Renumbering...';
        button.disabled = true;
        
        // Get all unique batch IDs from the current view
        const batchIds = [];
        document.querySelectorAll('[data-batch-id]').forEach(element => {
            const batchId = element.getAttribute('data-batch-id');
            if (!batchIds.includes(batchId)) {
                batchIds.push(batchId);
            }
        });
        
        console.log('Found batch IDs:', batchIds);
        
        // Send renumber request for each batch
        let completed = 0;
        const total = batchIds.length;
        
        if (total === 0) {
            alert('No batches found to renumber.');
            button.innerHTML = originalText;
            button.disabled = false;
            return;
        }
        
        batchIds.forEach(batchId => {
            fetch('{{ route("admin.material.chapter.renumber") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    batch_id: batchId
                })
            })
            .then(response => {
                console.log(`Renumber response for batch ${batchId}:`, response.status);
                return response.json();
            })
            .then(data => {
                completed++;
                console.log(`Batch ${batchId} completed:`, data);
                
                if (completed === total) {
                    if (data.success) {
                        alert(`All chapters renumbered successfully! Processed ${total} batch(es).`);
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                }
            })
            .catch(error => {
                console.error(`Error renumbering batch ${batchId}:`, error);
                completed++;
                
                if (completed === total) {
                    alert('An error occurred while renumbering chapters.');
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            });
        });
    }
}

// Add event listeners for delete buttons
document.addEventListener('DOMContentLoaded', function() {
    console.log('Chapter pagination page loaded');
    
    // Add click listeners to all delete buttons
    document.querySelectorAll('.delete-chapter-btn').forEach(button => {
        button.addEventListener('click', function() {
            const batchId = this.getAttribute('data-batch-id');
            const chapterNumber = this.getAttribute('data-chapter-number');
            const chapterName = this.getAttribute('data-chapter-name');
            
            console.log('Delete button clicked:', { batchId, chapterNumber, chapterName });
            
            deleteChapter(batchId, chapterNumber, chapterName);
        });
    });
});

// Auto-refresh stats every 30 seconds
setInterval(() => {
    console.log('Chapter stats auto-refresh');
}, 30000);
</script>
@endpush