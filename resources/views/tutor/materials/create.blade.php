@extends('layouts.admin.app')

@section('title', 'Tambah Materi')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('tutor.materials.index') }}">Materi</a></li>
    <li class="breadcrumb-item active">Tambah Materi</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-plus-circle"></i> Tambah Materi Pembelajaran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tutor.materials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="title">Judul Materi <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   placeholder="Masukkan judul materi" required value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Deskripsi materi pembelajaran">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="batch_id">Paket Ujian <span class="text-danger">*</span></label>
                            <select name="batch_id" id="batch_id" class="form-control @error('batch_id') is-invalid @enderror" required>
                                <option value="">Pilih paket ujian</option>
                                @foreach($paketUjians as $paket)
                                    <option value="{{ $paket->id }}" {{ old('batch_id') == $paket->id ? 'selected' : '' }}>
                                        {{ $paket->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pilih paket ujian untuk materi ini</small>
                            @error('batch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Jenis Materi <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                        <option value="">Pilih jenis materi</option>
                                        <option value="document" {{ old('type') == 'document' ? 'selected' : '' }}>Dokumen (PDF, DOC)</option>
                                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video Upload</option>
                                        <option value="youtube" {{ old('type') == 'youtube' ? 'selected' : '' }}>Video YouTube</option>
                                        <option value="link" {{ old('type') == 'link' ? 'selected' : '' }}>Link Eksternal</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mapel">Mata Pelajaran</label>
                                    <input type="text" name="mapel" id="mapel" class="form-control @error('mapel') is-invalid @enderror" 
                                           placeholder="Matematika, Fisika, dll" value="{{ old('mapel') }}">
                                    @error('mapel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Chapter Management -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chapter_number">Nomor Bab</label>
                                    <input type="number" name="chapter_number" id="chapter_number" class="form-control @error('chapter_number') is-invalid @enderror"
                                           min="1" placeholder="1" value="{{ old('chapter_number') }}">
                                    <small class="form-text text-muted">Nomor bab untuk mengelompokkan materi</small>
                                    @error('chapter_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="chapter_title">Judul Bab</label>
                                    <input type="text" name="chapter_title" id="chapter_title" class="form-control @error('chapter_title') is-invalid @enderror"
                                           placeholder="Bab 1: Pengenalan" value="{{ old('chapter_title') }}">
                                    <small class="form-text text-muted">Judul bab (opsional, akan menggunakan "Bab X" jika kosong)</small>
                                    @error('chapter_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="material_order">Urutan Materi</label>
                            <input type="number" name="material_order" id="material_order" class="form-control @error('material_order') is-invalid @enderror"
                                   min="0" placeholder="0" value="{{ old('material_order', 0) }}">
                            <small class="form-text text-muted">Urutan materi dalam bab (0 = urutan otomatis)</small>
                            @error('material_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Upload Section -->
                        <div class="form-group" id="fileSection" style="display: none;">
                            <label for="file">Upload File</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" 
                                   accept=".pdf,.doc,.docx,.mp4,.avi,.mov,.wmv">
                            <small class="form-text text-muted">Maksimal 100MB. Format: PDF, DOC, DOCX, MP4, AVI, MOV, WMV</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- YouTube URL Section -->
                        <div class="form-group" id="youtubeSection" style="display: none;">
                            <label for="youtube_url">URL YouTube <span class="text-danger">*</span></label>
                            <input type="url" name="youtube_url" id="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror" 
                                   placeholder="https://www.youtube.com/watch?v=..." value="{{ old('youtube_url') }}">
                            @error('youtube_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Thumbnail akan otomatis diambil dari YouTube</small>
                        </div>

                        <!-- External Link Section -->
                        <div class="form-group" id="linkSection" style="display: none;">
                            <label for="external_link">Link Eksternal <span class="text-danger">*</span></label>
                            <input type="url" name="external_link" id="external_link" class="form-control @error('external_link') is-invalid @enderror" 
                                   placeholder="https://example.com" value="{{ old('external_link') }}">
                            @error('external_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thumbnail Upload -->
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail (Opsional)</label>
                            <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                            <div class="mt-2" id="thumbnailPreviewContainer" style="display: none;">
                                <img id="thumbnailPreview" class="img-thumbnail thumbnail-preview" style="max-width: 120px; max-height: 120px; object-fit: cover;">
                            </div>
                            <small class="form-text text-muted">Upload gambar thumbnail (opsional, untuk YouTube akan otomatis diambil)</small>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Duration (for videos) -->
                        <div class="form-group" id="durationSection" style="display: none;">
                            <label for="duration_seconds">Durasi (detik)</label>
                            <input type="number" name="duration_seconds" id="duration_seconds" class="form-control @error('duration_seconds') is-invalid @enderror" 
                                   min="1" placeholder="3600" value="{{ old('duration_seconds') }}">
                            <small class="form-text text-muted">Contoh: 3600 = 1 jam</small>
                            @error('duration_seconds')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="form-group">
                            <label for="tags_input">Tags</label>
                            <input type="text" name="tags_input" id="tags_input" class="form-control" 
                                   placeholder="Matematika, Fisika, Tutorial" value="{{ old('tags_input') }}">
                            <small class="form-text text-muted">Pisahkan dengan koma untuk multiple tags</small>
                            <input type="hidden" name="tags" id="tags">
                        </div>

                        <!-- Settings -->
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_public" id="is_public" class="custom-control-input" 
                                       value="1" {{ old('is_public') ? 'checked' : '' }}>
                                <label for="is_public" class="custom-control-label">
                                    <i class="fas fa-globe"></i> Publikasikan untuk umum
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_featured" id="is_featured" class="custom-control-input"
                                       value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label for="is_featured" class="custom-control-label">
                                    <i class="fas fa-star"></i> Tandai sebagai unggulan
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_completable" id="is_completable" class="custom-control-input"
                                       value="1" {{ old('is_completable', true) ? 'checked' : '' }}>
                                <label for="is_completable" class="custom-control-label">
                                    <i class="fas fa-check-circle"></i> Izinkan Tandai Selesai
                                </label>
                                <small class="form-text text-muted">Centang agar siswa dapat menandai materi ini sebagai selesai</small>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <a href="{{ route('tutor.materials.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary float-right">
                                <i class="fas fa-save"></i> Simpan Materi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle type selection
    $('#type').change(function() {
        var type = $(this).val();
        
        // Hide all sections first
        $('#fileSection, #youtubeSection, #linkSection, #durationSection').hide();
        
        // Show relevant sections based on type
        if (type === 'document' || type === 'video') {
            $('#fileSection').show();
            if (type === 'video') {
                $('#durationSection').show();
            }
        } else if (type === 'youtube') {
            $('#youtubeSection').show();
            $('#durationSection').show();
        } else if (type === 'link') {
            $('#linkSection').show();
        }
    });
    
    // Handle tags input
    $('#tags_input').on('blur', function() {
        var tagsArray = $(this).val().split(',').map(tag => tag.trim()).filter(tag => tag !== '');
        $('#tags').val(JSON.stringify(tagsArray));
    });
    
    // Trigger type change on page load if there's an old value
    if ($('#type').val()) {
        $('#type').trigger('change');
    }

    // Initialize chapter fields
    $('#chapter_number').on('input', function() {
        var chapterNum = $(this).val();
        if (chapterNum && !$('#chapter_title').val()) {
            $('#chapter_title').val('Bab ' + chapterNum);
        }
    });

    // Image preview function
    function previewImage(input) {
        const previewContainer = document.getElementById('thumbnailPreviewContainer');
        const preview = document.getElementById('thumbnailPreview');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Silakan pilih file gambar yang valid.');
                input.value = '';
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (preview) {
                    preview.src = e.target.result;
                    if (previewContainer) {
                        previewContainer.style.display = 'block';
                    }
                }
            };
            
            reader.readAsDataURL(file);
        } else {
            // Reset preview
            if (previewContainer) {
                previewContainer.style.display = 'none';
            }
            if (preview) {
                preview.src = '';
            }
        }
    }
});
</script>
@endpush

@push('styles')
<style>
.thumbnail-preview {
    border: 2px solid #dee2e6;
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.15s ease-in-out;
}

.thumbnail-preview:hover {
    transform: scale(1.02);
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);
}

/* Ensure form layout doesn't break */
.form-group {
    margin-bottom: 1.5rem;
}

.form-control {
    font-size: 0.9rem;
}
</style>
@endpush