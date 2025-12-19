@extends('layouts/admin/app')

@section('title')
Data Testimonial
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="{{ route('admin.testimonial.index') }}">Testimonial</a></li>
<li class="breadcrumb-item active">{{ isset($testimonial->id) ? 'Edit' : 'Tambah' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="form" action="{{ $action }}" method="post" class="form-horizontal needs-validation" autocomplete="off" enctype="multipart/form-data" novalidate>
                        @csrf
                        @if(isset($testimonial->id))
                        @method('put')
                        @endif

                        <div class="form-group required">
                            <label for="name" class="col-sm-3 col-form-label">Nama</label>
                            <input type="text" class="form-control" value="{{ old('name', $testimonial->name ?? '') }}" name="name" id="name" placeholder="Nama testimonial" required>
                            @error('name')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="graduation" class="col-sm-3 col-form-label">Lulusan</label>
                            <input type="text" class="form-control" value="{{ old('graduation', $testimonial->graduation ?? '') }}" name="graduation" id="graduation" placeholder="Contoh: Universitas Indonesia, SMA Negeri 1 Jakarta">
                            @error('graduation')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group required">
                            <label for="message" class="col-sm-3 col-form-label">Pesan</label>
                            <textarea id="message" class="form-control @error('message') is-invalid @enderror" name="message" rows="4" placeholder="Pesan testimonial" required>{{ old('message', $testimonial->message ?? '') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group required">
                            <label for="rating" class="col-sm-3 col-form-label">Rating</label>
                            <select class="form-control @error('rating') is-invalid @enderror" name="rating" id="rating" required>
                                <option value="">Pilih Rating</option>
                                @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                                @endfor
                            </select>
                            @error('rating')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image" class="col-sm-3 col-form-label">Gambar (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                                <label class="custom-file-label" for="image">Pilih gambar...</label>
                            </div>
                            @if(isset($testimonial->image) && $testimonial->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                                <p class="text-muted">Gambar saat ini</p>
                            </div>
                            @endif
                            @error('image')
                            <div class="invalid-feedback d-block">
                                <h6>{{ $message }}</h6>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
                                <label for="is_active" class="custom-control-label">
                                    Aktif
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline-success mt-3 float-right">Simpan</button>
                        <a href="{{ route('admin.testimonial.index') }}" class="btn btn-outline-secondary mt-3 float-right mr-2">Batal</a>
                    </form>
                    <!-- /.row -->
                </div>
                <!-- ./card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->

    <!-- /.row -->
</div>

@endsection

@push('scripts')
<script src="{{ asset('adminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>
@endpush