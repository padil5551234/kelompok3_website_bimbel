@extends('layouts.user.app_new')

@section('title', 'Edit Materi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Edit Materi: {{ $material->title }}</h6>
                        <a href="{{ route('tutor.materials.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('tutor.materials.update', $material) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch_id">Paket / Batch <span class="text-danger">*</span></label>
                                    <select name="batch_id" id="batch_id" class="form-control" required>
                                        <option value="">Pilih Paket</option>
                                        @foreach($paketUjians as $paket)
                                            <option value="{{ $paket->id }}" {{ old('batch_id', $material->batch_id) == $paket->id ? 'selected' : '' }}>
                                                {{ $paket->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('batch_id')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mapel">Mata Pelajaran <small class="text-muted">(Opsional)</small></label>
                                    <input type="text" name="mapel" id="mapel" class="form-control" value="{{ old('mapel', $material->mapel) }}" placeholder="Contoh: Matematika, TIU, TKP">
                                    @error('mapel')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Judul Materi <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $material->title) }}" required>
                            @error('title')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $material->description) }}</textarea>
                            @error('description')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">Tipe Materi <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="youtube" {{ old('type', $material->type) == 'youtube' ? 'selected' : '' }}>Video YouTube</option>
                                <option value="video" {{ old('type', $material->type) == 'video' ? 'selected' : '' }}>Video Upload</option>
                                <option value="document" {{ old('type', $material->type) == 'document' ? 'selected' : '' }}>Dokumen (PDF, DOC)</option>
                                <option value="link" {{ old('type', $material->type) == 'link' ? 'selected' : '' }}>Link Eksternal</option>
                            </select>
                            @error('type')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- YouTube URL -->
                        <div class="form-group" id="youtube_url_group" style="display: none;">
                            <label for="youtube_url">URL YouTube <span class="text-danger">*</span></label>
                            <input type="url" name="youtube_url" id="youtube_url" class="form-control" value="{{ old('youtube_url', $material->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                            <small class="text-muted">Masukkan link video YouTube</small>
                            @error('youtube_url')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- External Link -->
                        <div class="form-group" id="external_link_group" style="display: none;">
                            <label for="external_link">Link Eksternal <span class="text-danger">*</span></label>
                            <input type="url" name="external_link" id="external_link" class="form-control" value="{{ old('external_link', $material->external_link) }}" placeholder="https://...">
                            @error('external_link')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="form-group" id="file_group" style="display: none;">
                            <label for="file">Upload File</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx,.mp4,.avi,.mov,.wmv">
                            @if($material->file_path)
                                <small class="text-muted">File saat ini: {{ basename($material->file_path) }} ({{ $material->getFormattedFileSize() }})</small>
                            @endif
                            <br><small class="text-muted">Format: PDF, DOC, DOCX, MP4, AVI, MOV, WMV (Max: 100MB)</small>
                            @error('file')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="thumbnail">Thumbnail (Opsional)</label>
                            <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*" onchange="previewImage(this)">
                            @if($material->thumbnail_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $material->thumbnail_path) }}" alt="Current thumbnail" class="img-thumbnail thumbnail-preview" id="currentThumbnail" style="max-width: 120px; max-height: 120px; object-fit: cover;">
                                </div>
                            @endif
                            <div class="mt-2" id="thumbnailPreviewContainer" style="display: none;">
                                <img id="thumbnailPreview" class="img-thumbnail thumbnail-preview" style="max-width: 120px; max-height: 120px; object-fit: cover;">
                            </div>
                            <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                            @error('thumbnail')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Chapter Information -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chapter_number">Nomor Bab</label>
                                    <input type="number" name="chapter_number" id="chapter_number" class="form-control"
                                           min="1" value="{{ old('chapter_number', $material->chapter_number) }}"
                                           placeholder="1">
                                    <small class="form-text text-muted">Nomor bab dalam paket (opsional)</small>
                                    @error('chapter_number')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chapter_title">Judul Bab</label>
                                    <input type="text" name="chapter_title" id="chapter_title" class="form-control"
                                           value="{{ old('chapter_title', $material->chapter_title) }}"
                                           placeholder="Bab 1: Pengenalan">
                                    <small class="form-text text-muted">Judul bab (opsional)</small>
                                    @error('chapter_title')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="material_order">Urutan Materi</label>
                                    <input type="number" name="material_order" id="material_order" class="form-control"
                                           min="0" value="{{ old('material_order', $material->material_order) }}"
                                           placeholder="0">
                                    <small class="form-text text-muted">Urutan dalam bab (0 = default)</small>
                                    @error('material_order')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duration_seconds">Durasi (detik)</label>
                                    <input type="number" name="duration_seconds" id="duration_seconds" class="form-control" value="{{ old('duration_seconds', $material->duration_seconds) }}" placeholder="Contoh: 300 untuk 5 menit">
                                    @error('duration_seconds')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tags">Tags (pisahkan dengan koma)</label>
                                    <input type="text" name="tags[]" id="tags" class="form-control" value="{{ old('tags') ? implode(',', old('tags')) : ($material->tags ? implode(',', $material->tags) : '') }}" placeholder="matematika, tiu, tkp">
                                    @error('tags')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public', $material->is_public) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_public">Materi Publik</label>
                                    <br><small class="text-muted">Dapat diakses oleh semua user</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $material->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Materi Featured</label>
                                    <br><small class="text-muted">Tampilkan di halaman utama</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_completable" id="is_completable" value="1" {{ old('is_completable', $material->is_completable) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_completable">Dapat Ditandai Selesai</label>
                                    <br><small class="text-muted">Izinkan siswa tandai selesai</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content">Konten Tambahan (Opsional)</label>
                            <textarea name="content" id="content" class="form-control" rows="5">{{ old('content', $material->content) }}</textarea>
                            <small class="text-muted">Tambahan penjelasan atau catatan untuk materi ini</small>
                            @error('content')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('tutor.materials.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Materi</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const youtubeUrlGroup = document.getElementById('youtube_url_group');
        const externalLinkGroup = document.getElementById('external_link_group');
        const fileGroup = document.getElementById('file_group');
        const youtubeUrlInput = document.getElementById('youtube_url');
        const externalLinkInput = document.getElementById('external_link');
        const fileInput = document.getElementById('file');

        function toggleFields() {
            const selectedType = typeSelect.value;
            
            // Hide all groups
            youtubeUrlGroup.style.display = 'none';
            externalLinkGroup.style.display = 'none';
            fileGroup.style.display = 'none';
            
            // Remove required attributes
            youtubeUrlInput.removeAttribute('required');
            externalLinkInput.removeAttribute('required');
            fileInput.removeAttribute('required');
            
            // Show relevant group
            if (selectedType === 'youtube') {
                youtubeUrlGroup.style.display = 'block';
                youtubeUrlInput.setAttribute('required', 'required');
            } else if (selectedType === 'link') {
                externalLinkGroup.style.display = 'block';
                externalLinkInput.setAttribute('required', 'required');
            } else if (selectedType === 'video' || selectedType === 'document') {
                fileGroup.style.display = 'block';
            }
        }

        typeSelect.addEventListener('change', toggleFields);
        toggleFields(); // Initial call

        // Initialize chapter fields
        const chapterNumberInput = document.getElementById('chapter_number');
        if (chapterNumberInput) {
            chapterNumberInput.addEventListener('input', function() {
                const chapterNum = this.value;
                const chapterTitleInput = document.getElementById('chapter_title');
                if (chapterNum && chapterTitleInput && !chapterTitleInput.value) {
                    chapterTitleInput.value = 'Bab ' + chapterNum;
                }
            });
        }

        // Handle tags input
        const tagsInput = document.getElementById('tags');
        tagsInput.addEventListener('change', function() {
            const tags = this.value.split(',').map(tag => tag.trim()).filter(tag => tag);
            this.value = tags.join(',');
        });
    });

    // Image preview function
    function previewImage(input) {
        const previewContainer = document.getElementById('thumbnailPreviewContainer');
        const preview = document.getElementById('thumbnailPreview');
        const currentThumbnail = document.getElementById('currentThumbnail');

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
                    // Hide current thumbnail when new one is selected
                    if (currentThumbnail) {
                        currentThumbnail.style.display = 'none';
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
            // Show current thumbnail again
            if (currentThumbnail) {
                currentThumbnail.style.display = 'block';
            }
        }
    }
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