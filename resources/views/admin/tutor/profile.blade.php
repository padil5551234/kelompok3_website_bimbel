@extends('layouts/admin/app')

@section('title')
Profile Tutor
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="{{ route('admin.tutor.index') }}">Tutor</a></li>
<li class="breadcrumb-item active">Profile {{ $tutor->name }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kelola Profile Tutor: {{ $tutor->name }}</h3>
                </div>
                <div class="card-body">
                    <form id="form" action="{{ $action }}" method="post" class="form-horizontal needs-validation" autocomplete="off" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="image" class="col-sm-3 col-form-label">Foto Tutor</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                                <label class="custom-file-label" for="image">Pilih foto...</label>
                            </div>
                            @if($tutorProfile->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $tutorProfile->image) }}" alt="Foto Tutor" class="img-thumbnail" style="max-width: 200px;">
                                <p class="text-muted">Foto saat ini</p>
                            </div>
                            @endif
                            @error('image')
                            <div class="invalid-feedback d-block">
                                <h6>{{ $message }}</h6>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bio" class="col-sm-3 col-form-label">Bio</label>
                            <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" rows="4" placeholder="Deskripsi singkat tentang tutor">{{ old('bio', $tutorProfile->bio ?? '') }}</textarea>
                            @error('bio')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="specialization" class="col-sm-3 col-form-label">Spesialisasi</label>
                            <input type="text" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization', $tutorProfile->specialization ?? '') }}" name="specialization" id="specialization" placeholder="Contoh: Matematika, Fisika, dll">
                            @error('specialization')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="experience" class="col-sm-3 col-form-label">Pengalaman</label>
                            <input type="text" class="form-control @error('experience') is-invalid @enderror" value="{{ old('experience', $tutorProfile->experience ?? '') }}" name="experience" id="experience" placeholder="Contoh: 5 tahun mengajar">
                            @error('experience')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $tutorProfile->is_active ?? true) ? 'checked' : '' }}>
                                <label for="is_active" class="custom-control-label">
                                    Profile Aktif
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline-success mt-3 float-right">Simpan Profile</button>
                        <a href="{{ route('admin.tutor.index') }}" class="btn btn-outline-secondary mt-3 float-right mr-2">Kembali</a>
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