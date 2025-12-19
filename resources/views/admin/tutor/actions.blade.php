<div class="btn-group">
    <button type="button" class="btn btn-sm btn-outline-primary" onclick="editForm('{{ route('admin.tutor.edit', $tutor) }}')" title="Edit">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" class="btn btn-sm btn-outline-info" onclick="manageProfile('{{ route('admin.tutor.profile', $tutor) }}')" title="Kelola Profile">
        <i class="fa fa-user"></i>
    </button>
    <button type="button" class="btn btn-sm btn-outline-warning" onclick="resetPassword('{{ route('admin.tutor.resetpassword', $tutor) }}')" title="Reset Password">
        <i class="fa fa-key"></i>
    </button>
    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteData('{{ route('admin.tutor.destroy', $tutor) }}')" title="Hapus">
        <i class="fa fa-trash"></i>
    </button>
</div>