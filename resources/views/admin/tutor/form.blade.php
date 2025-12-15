<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tutor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate>
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">
                                    Nama wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">
                                    Email wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="password" name="password" required minlength="8">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="generatePass('new')">Generate</button>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                            <i class="fa fa-eye" id="password-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    Password minimal 8 karakter.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                            <i class="fa fa-eye" id="password_confirmation-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    Konfirmasi password wajib diisi.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>