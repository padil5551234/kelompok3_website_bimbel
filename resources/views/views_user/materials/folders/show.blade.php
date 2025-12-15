@extends('layouts.user.app')

@section('title', $folder->formatted_title)

@section('content')

<section id="folder-detail" class="folder-detail">
    <div class="container" data-aos="fade-up">
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('user.materials.folders.index') }}" class="btn btn-secondary btn-sm mb-3">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Folder
                </a>
                
                <div class="folder-header">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-folder fa-3x text-warning me-3"></i>
                        <div>
                            <h2 class="mb-1">{{ $folder->formatted_title }}</h2>
                            @if($folder->description)
                                <p class="text-muted mb-2">{{ $folder->description }}</p>
                            @endif
                            <div class="folder-meta">
                                @if($folder->tutor)
                                    <span class="badge bg-primary me-2">
                                        <i class="fas fa-user"></i> {{ $folder->tutor->name }}
                                    </span>
                                @endif
                                @if($folder->batch)
                                    <span class="badge bg-secondary me-2">
                                        <i class="fas fa-graduation-cap"></i> {{ $folder->batch->nama }}
                                    </span>
                                @endif
                                <span class="badge bg-info">
                                    <i class="fas fa-file-alt"></i> {{ $folder->total_materials_count }} Materi
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($folder->materials->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                            <h5>Folder Kosong</h5>
                            <p class="text-muted">Belum ada materi yang ditambahkan ke folder ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($folder->materials as $material)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 material-card">
                            <div class="card-body">
                                <h5 class="card-title">{{ Str::limit($material->title, 60) }}</h5>
                                <p class="card-text text-muted small">
                                    {{ Str::limit($material->description, 120) }}
                                </p>
                                <a href="{{ route('user.materials.show', $material) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Lihat Materi
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection