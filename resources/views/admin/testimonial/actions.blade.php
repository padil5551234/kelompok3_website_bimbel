<div class="btn-group">
    <button type="button" class="btn btn-sm btn-outline-primary" onclick="editForm('{{ route('admin.testimonial.edit', $testimonial) }}')" title="Edit">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteData('{{ route('admin.testimonial.destroy', $testimonial) }}')" title="Hapus">
        <i class="fa fa-trash"></i>
    </button>
</div>