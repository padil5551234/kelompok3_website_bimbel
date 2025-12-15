@extends('layouts.admin.app')

@section('title')
    Profile
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        @if (\Session::has('message'))
            <div class="col-lg-12">
                <div class="alert alert-danger">
                    {{ \Session::get('message') }}
                </div>
            </div>
        @endif
        
        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" 
                             src="{{ $user->profile_photo_url }}" 
                             alt="User profile picture"
                             style="width: 100px; height: 100px;">
                    </div>
                    <h3 class="profile-username text-center">{{ $user->name }}</h3>
                    <p class="text-muted text-center">{{ $user->email }}</p>
                    <p class="text-center">
                        <span class="badge badge-success">Tutor</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Akun</h3>
                </div>
                <div class="card-body">
                    <form id="formAccount" action="{{ route('profile.account') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="Name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $user->name }}" name="name" id="Name" 
                                   class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $user->email }}" readonly name="email" id="Email" 
                                   class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="No_hp">No HP <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $user->usersDetail ? $user->usersDetail->no_hp : '' }}" 
                                   name="no_hp" id="No_hp" class="form-control" placeholder="No Handphone" required>
                        </div>
                        <div class="form-group">
                            <label for="sumber">Sumber Mendapatkan Tryout <span class="text-danger">*</span></label>
                            <select class="form-control sumber" id="Sumber" name="sumber[]" multiple="multiple"
                                    data-placeholder="--Pilih Sumber Informasi Mendapatkan Tryout--" style="width: 100%;">
                                <option value="Instagram">Instagram</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="Email">Email</option>
                                <option value="Internet">Internet</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Foto Profil</label>
                            <input type="file" name="image" placeholder="Pilih Foto Profil" 
                                   class="form-control" id="image">
                            <small class="text-danger">*Upload foto berukuran maksimal 1MB</small>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="submitAccount" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
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
    $('.sumber').select2({
        theme: 'bootstrap4'
    });

    @if ($user->usersDetail != NULL)
    $('#Sumber').val(@json($user->usersDetail->sumber_informasi)).change();
    @endif

    $('#formAccount').on('submit', function(e) {
        e.preventDefault();
        let submitButton = $('#submitAccount');
        let originalHtml = submitButton.html();

        submitButton.html('<i class="fas fa-spinner fa-spin"></i> Loading...');
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
                if ($.isEmptyObject(response.error)) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    $.each(response.error, function(key, val) {
                        toastr.error(val);
                    });
                }
            },
            error: function(errors) {
                submitButton.html(originalHtml);
                submitButton.prop('disabled', false);
                toastr.options = {"positionClass": "toast-bottom-right"};
                toastr.error(errors.responseJSON.message);
            }
        });
    });
});
</script>
@endpush