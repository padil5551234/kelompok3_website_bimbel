@extends('layouts/admin/app')

@section('title')
Tambah Artikel
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="{{ route('admin.article.index') }}">Artikel</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endsection

@push('links')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Artikel</h3>
                </div>
                <form action="{{ route('admin.article.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="title">Judul Artikel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="excerpt">Ringkasan</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" required>{{ old('content') }}</textarea>
                            @error('content')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category') is-invalid @enderror" 
                                            id="category" name="category" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $key => $value)
                                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="featured_image">Gambar Unggulan</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('featured_image') is-invalid @enderror" 
                                       id="featured_image" name="featured_image" accept="image/*">
                                <label class="custom-file-label" for="featured_image">Pilih file</label>
                            </div>
                            <small class="form-text text-muted">Maksimal 2MB. Format: JPG, PNG, JPEG</small>
                            @error('featured_image')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                   id="tags" name="tags" value="{{ old('tags') }}" 
                                   placeholder="Pisahkan dengan koma (contoh: tips, strategi, cpns)">
                            @error('tags')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description (untuk SEO)</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="2">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_featured" 
                                       name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_featured">
                                    Artikel Unggulan
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.article.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(function() {
        // Initialize Summernote
        $('#content').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Custom file input label
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
@endpush