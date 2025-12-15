@extends('layouts/admin/app')

@section('title')
    Data Tutor
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Tutor</li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <button onclick="addForm('{{ route('admin.tutor.store') }}')" class="btn btn-outline-success"><i
                                class="fa fa-plus-circle"></i> Tambah Tutor</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="" method="post" class="form-member">
                            @csrf
                            <table class="table table-bordered table-striped center-header" id="Table-Tutor">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Materi</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Dibuat</th>
                                        <th style="width: 15%"><i class="fa fa-cog"></i></th>
                                    </tr>
                                </thead>
                            </table>
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

    @includeIf('admin.tutor.form')
    @includeIf('admin.tutor.reset')

@endsection

@push('scripts')
    <script>
        let tableTutor;
        $(function () {
            tableTutor = $('#Table-Tutor').DataTable({
                processing: true
                , serverside: true
                , responsive: true
                , autoWidth: false
                , ajax: {
                    url: '{{ route('admin.tutor.data') }}'
                    ,
                }
                , columns: [{
                    data: 'DT_RowIndex'
                    , searchable: false
                    , sortable: false
                }
                    , {
                    data: 'name'
                }
                    , {
                    data: 'email'
                }
                    , {
                    data: 'created_at'
                }
                    , {
                    data: 'aksi'
                    , searchable: false
                    , sortable: false
                }
                    ,]
                , dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip'
                , columnDefs: [
                    { className: 'text-center', targets: [0, 3, 4] },
                ]
            });

            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })

            $('#modal-form form').on('submit', function (e) {
                if (!e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            tableTutor.ajax.reload();
                            toastr.options = { "positionClass": "toast-bottom-right" };
                            toastr.success('Data berhasil disimpan.');
                        })
                        .fail((errors) => {
                            // toastr.error('Tidak dapat menyimpan data.');
                            return;
                        });
                }
            }
            )

            $('#modal-reset form').on('submit', function (e) {
                if (!e.preventDefault()) {
                    $.post($('#modal-reset form').attr('action'), $('#modal-reset form').serialize())
                        .done((response) => {
                            $('#modal-reset').modal('hide');
                            toastr.options = { "positionClass": "toast-bottom-right" };
                            toastr.success('Password berhasil direset.');
                        })
                        .fail((errors) => {
                            // toastr.error('Tidak dapat menyimpan data.');
                            return;
                        });
                }
            }
            )
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Tutor');

            $('#modal-form form')[0].classList.remove('was-validated');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=name]').focus();
        }

        function editForm(url) {
            $.get(url)
                .done((response) => {
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Tutor');

                    $('#modal-form form')[0].classList.remove('was-validated');
                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('put');
                    $('#modal-form [name=name]').val(response.name);
                    $('#modal-form [name=email]').val(response.email);
                    $('#modal-form [name=name]').focus();
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data.');
                    return;
                });
        }

        function deleteData(url) {
            Swal.fire({
                title: 'Apakah kamu yakin akan menghapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        '_method': 'delete'
                    })
                        .done((response) => {
                            tableTutor.ajax.reload();
                            toastr.options = { "positionClass": "toast-bottom-right" };
                            toastr.success(response.success || 'Data berhasil dihapus.');
                        })
                        .fail((xhr) => {
                            let errorMessage = 'Tidak dapat menghapus data.';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorMessage = xhr.responseJSON.error;
                            }
                            toastr.error(errorMessage);
                            console.error('Delete error:', xhr);
                            return;
                        })
                }
            })
        }

        function generatePass(name) {
            // Generate random password
            var pass = '';
            var str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                + 'abcdefghijklmnopqrstuvwxyz0123456789@#$';

            for (let i = 1; i <= 8; i++) {
                var char = Math.floor(Math.random() * str.length + 1);
                pass += str.charAt(char)
            }
            if (name === 'reset') {
                $('#PasswordReset').val(pass);
                $('#PasswordReset').attr('type', 'text');
                $('#PasswordReset-icon').removeClass('fa-eye').addClass('fa-eye-slash');
                $('#password_confirmation_reset').val(pass);
                $('#password_confirmation_reset').attr('type', 'text');
                $('#password_confirmation_reset-icon').removeClass('fa-eye').addClass('fa-eye-slash');
            } else if (name === 'new') {
                $('#password').val(pass);
                $('#password').attr('type', 'text');
                $('#password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
                $('#password_confirmation').val(pass);
                $('#password_confirmation').attr('type', 'text');
                $('#password_confirmation-icon').removeClass('fa-eye').addClass('fa-eye-slash');
            }
        }

        function togglePassword(fieldId) {
            var field = $('#' + fieldId);
            var icon = $('#' + fieldId + '-icon');

            if (field.attr('type') === 'password') {
                field.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                field.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        }

        function resetPassword(url) {
            $('#modal-reset').modal('show');
            $('#modal-reset .modal-title').text('Reset Password Tutor');

            $('#modal-reset form')[0].classList.remove('was-validated');
            $('#modal-reset form')[0].reset();
            $('#modal-reset form').attr('action', url);
            $('#modal-reset [name=_method]').val('post');
            $('#modal-reset [name=name]').focus();
        }

    </script>
@endpush