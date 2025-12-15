@extends('layouts.admin.app')

@section('title', 'Detail Materi')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .material-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .material-type-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-right: 10px;
        }
        
        .badge-video { background: #e74c3c; color: white; }
        .badge-document { background: #3498db; color: white; }
        .badge-link { background: #2ecc71; color: white; }
        .badge-youtube { background: #c4302b; color: white; }
        
        .material-stats {
            display: flex;
            gap: 20px;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
        }
        
        .content-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .video-container iframe,
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .thumbnail-container {
            max-width: 100%;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .thumbnail-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .material-content {
            line-height: 1.8;
            color: #333;
        }
        
        .material-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 15px 0;
        }
        
        .tag-list {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 15px;
        }
        
        .tag-item {
            background: #f0f0f0;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            color: #666;
        }
        
        @media (max-width: 768px) {
            .material-stats {
                flex-direction: column;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Materi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('tutor.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('tutor.materials.index') }}">Materi</a></div>
                    <div class="breadcrumb-item active">Detail</div>
                </div>
            </div>

            <div class="section-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <!-- Material Header -->
                <div class="material-header">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div class="flex-grow-1">
                            <div class="mb-3">
                                <span class="material-type-badge badge-{{ $material->type }}">
                                    <i class="fas fa-{{ $material->getTypeIcon() }}"></i> {{ ucfirst($material->type) }}
                                </span>
                                @if($material->is_public)
                                    <span class="badge badge-success"><i class="fas fa-globe"></i> Publik</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fas fa-lock"></i> Privat</span>
                                @endif
                                @if($material->is_featured)
                                    <span class="badge badge-warning"><i class="fas fa-star"></i> Unggulan</span>
                                @endif
                            </div>
                            <h2 class="mb-2">{{ $material->title }}</h2>
                            @if($material->mapel)
                                <p class="mb-2"><i class="fas fa-book"></i> {{ $material->mapel }}</p>
                            @endif
                            @if($material->batch)
                                <p class="mb-0"><i class="fas fa-folder"></i> Batch: {{ $material->batch->nama }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="material-stats">
                        <div class="stat-item">
                            <i class="fas fa-eye"></i>
                            <span>{{ $material->views_count }} Views</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-download"></i>
                            <span>{{ $material->downloads_count }} Downloads</span>
                        </div>
                        @if($material->duration_seconds)
                            <div class="stat-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ $material->getFormattedDuration() }}</span>
                            </div>
                        @endif
                        <div class="stat-item">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $material->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Content Card -->
                <div class="content-card">
                    <!-- Thumbnail (if exists and not video/youtube) -->
                    @if($material->thumbnail_path && !in_array($material->type, ['video', 'youtube']))
                        <div class="thumbnail-container">
                            <img src="{{ $material->getThumbnailUrl() }}" alt="{{ $material->title }}">
                        </div>
                    @endif

                    <!-- Video/YouTube Content -->
                    @if($material->type === 'video' && $material->file_path)
                        <div class="video-container">
                            <video controls>
                                <source src="{{ asset('storage/' . $material->file_path) }}" type="{{ $material->file_type }}">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @elseif($material->type === 'youtube' && $material->youtube_url)
                        <div class="video-container">
                            <iframe src="{{ $material->getEmbedUrl() }}" allowfullscreen></iframe>
                        </div>
                    @endif

                    <!-- Description -->
                    @if($material->description)
                        <div class="mb-4">
                            <h5><i class="fas fa-align-left"></i> Deskripsi</h5>
                            <p class="text-muted">{{ $material->description }}</p>
                        </div>
                    @endif

                    <!-- Content -->
                    @if($material->content)
                        <div class="mb-4">
                            <h5><i class="fas fa-file-alt"></i> Konten</h5>
                            <div class="material-content">
                                {!! nl2br(e($material->content)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- External Link -->
                    @if($material->type === 'link' && $material->external_link)
                        <div class="mb-4">
                            <h5><i class="fas fa-external-link-alt"></i> Link Eksternal</h5>
                            <a href="{{ $material->external_link }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-external-link-alt"></i> Buka Link
                            </a>
                        </div>
                    @endif

                    <!-- Tags -->
                    @if($material->tags && count($material->tags) > 0)
                        <div class="mb-4">
                            <h5><i class="fas fa-tags"></i> Tags</h5>
                            <div class="tag-list">
                                @foreach($material->tags as $tag)
                                    <span class="tag-item">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- File Info (for documents) -->
                    @if($material->type === 'document' && $material->file_path)
                        <div class="mb-4">
                            <h5><i class="fas fa-file"></i> Informasi File</h5>
                            <ul class="list-unstyled">
                                <li><strong>Ukuran:</strong> {{ $material->getFormattedFileSize() }}</li>
                                <li><strong>Tipe:</strong> {{ $material->file_type }}</li>
                            </ul>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('tutor.materials.edit', $material->id) }}" class="btn btn-warning btn-action">
                            <i class="fas fa-edit"></i> Edit Materi
                        </a>

                        @if($material->isDownloadable())
                            <a href="{{ route('tutor.materials.download', $material->id) }}" class="btn btn-info btn-action">
                                <i class="fas fa-download"></i> Download
                            </a>
                        @endif

                        <form action="{{ route('tutor.materials.toggle-public', $material->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-{{ $material->is_public ? 'secondary' : 'success' }} btn-action">
                                <i class="fas fa-{{ $material->is_public ? 'lock' : 'globe' }}"></i> 
                                {{ $material->is_public ? 'Privatkan' : 'Publikasikan' }}
                            </button>
                        </form>

                        <form action="{{ route('tutor.materials.toggle-featured', $material->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-{{ $material->is_featured ? 'outline-warning' : 'warning' }} btn-action">
                                <i class="fas fa-star"></i> 
                                {{ $material->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}
                            </button>
                        </form>

                        <a href="{{ route('tutor.materials.index') }}" class="btn btn-secondary btn-action">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                        <button type="button" class="btn btn-danger btn-action" data-toggle="modal" data-target="#deleteModal">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus materi <strong>{{ $material->title }}</strong>?
                    <br><br>
                    <span class="text-danger">Tindakan ini tidak dapat dibatalkan!</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form action="{{ route('tutor.materials.destroy', $material->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endpush