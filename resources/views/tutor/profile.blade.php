@extends('layouts.admin.app')

@section('title')
    Profile Tutor
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        @if (session('success'))
            <div class="col-lg-12">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if($tutorProfile->image)
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ asset('storage/' . $tutorProfile->image) }}"
                                 alt="Tutor profile picture"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ asset('img/default-tutor.png') }}"
                                 alt="Default tutor picture"
                                 style="width: 100px; height: 100px;">
                        @endif
                    </div>
                    <h3 class="profile-username text-center">{{ $tutor->name }}</h3>
                    <p class="text-muted text-center">{{ $tutor->email }}</p>
                    <p class="text-center">
                        <span class="badge badge-success">Tutor</span>
                    </p>
                    @if($tutorProfile->specialization)
                        <p class="text-center text-muted">{{ $tutorProfile->specialization }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Profile Tutor</h3>
                </div>
                <div class="card-body">
                    <form id="formProfile" action="{{ route('tutor.profile.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="image">Foto Profil</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            <small class="text-muted">Upload foto berukuran maksimal 2MB (JPEG, PNG, JPG, GIF)</small>
                        </div>

                        <div class="form-group">
                            <label for="specialization">Spesialisasi</label>
                            <input type="text" name="specialization" id="specialization"
                                   class="form-control" placeholder="Contoh: Matematika, SKD"
                                   value="{{ old('specialization', $tutorProfile->specialization) }}">
                            <small class="text-muted">Bidang keahlian Anda sebagai tutor</small>
                        </div>

                        <div class="form-group">
                            <label for="experience">Pengalaman</label>
                            <input type="text" name="experience" id="experience"
                                   class="form-control" placeholder="Contoh: 3 tahun mengajar"
                                   value="{{ old('experience', $tutorProfile->experience) }}">
                            <small class="text-muted">Pengalaman mengajar Anda</small>
                        </div>

                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea name="bio" id="bio" class="form-control" rows="4"
                                      placeholder="Ceritakan sedikit tentang diri Anda sebagai tutor...">{{ old('bio', $tutorProfile->bio) }}</textarea>
                            <small class="text-muted">Deskripsi singkat tentang diri Anda (maksimal 1000 karakter)</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="submitProfile" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Profile
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
$(function() {
    $('#formProfile').on('submit', function(e) {
        e.preventDefault();
        let submitButton = $('#submitProfile');
        let originalHtml = submitButton.html();

        submitButton.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        submitButton.prop('disabled', true);

        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            contentType: false,
            processData: false,
            success: function(response) {
                submitButton.html(originalHtml);
                submitButton.prop('disabled', false);

                toastr.options = {"positionClass": "toast-bottom-right"};
                toastr.success('Profile berhasil diperbarui');

                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(errors) {
                submitButton.html(originalHtml);
                submitButton.prop('disabled', false);

                toastr.options = {"positionClass": "toast-bottom-right"};

                if (errors.responseJSON && errors.responseJSON.errors) {
                    $.each(errors.responseJSON.errors, function(key, val) {
                        toastr.error(val[0]);
                    });
                } else {
                    toastr.error('Terjadi kesalahan saat menyimpan profile');
                }
            }
        });
    });
});
</script>
@endpush