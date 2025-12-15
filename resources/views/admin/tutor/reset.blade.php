<!-- Modal Reset Password -->
<div class="modal fade" id="modal-reset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate>
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="PasswordReset">Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="PasswordReset" name="password" required minlength="8">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="generatePass('reset')">Generate</button>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('PasswordReset')">
                                    <i class="fa fa-eye" id="PasswordReset-icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            Password minimal 8 karakter.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation_reset">Konfirmasi Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="password_confirmation_reset" name="password_confirmation" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation_reset')">
                                    <i class="fa fa-eye" id="password_confirmation_reset-icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            Konfirmasi password wajib diisi.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>