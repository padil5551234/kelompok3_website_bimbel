<div class="btn-group" role="group">
    <button type="button" class="btn btn-info btn-sm" onclick="showForm('{{ route('admin.material.show', $material) }}')" title="Lihat Detail">
        <i class="fa fa-eye"></i>
    </button>
    <button type="button" class="btn btn-warning btn-sm" onclick="editForm('{{ route('admin.material.edit', $material) }}')" title="Edit">
        <i class="fa fa-edit"></i>
    </button>
    @if($material->is_featured)
        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleFeatured('{{ route('admin.material.toggle-featured', $material) }}')" title="Batal Unggulan">
            <i class="fa fa-star-half-alt"></i>
        </button>
    @else
        <button type="button" class="btn btn-warning btn-sm" onclick="toggleFeatured('{{ route('admin.material.toggle-featured', $material) }}')" title="Jadikan Unggulan">
            <i class="fa fa-star"></i>
        </button>
    @endif
    @if($material->is_public)
        <button type="button" class="btn btn-success btn-sm" onclick="togglePublic('{{ route('admin.material.toggle-public', $material) }}')" title="Jadikan Privat">
            <i class="fa fa-globe"></i>
        </button>
    @else
        <button type="button" class="btn btn-warning btn-sm" onclick="togglePublic('{{ route('admin.material.toggle-public', $material) }}')" title="Jadikan Publik">
            <i class="fa fa-lock"></i>
        </button>
    @endif
    <button type="button" class="btn btn-danger btn-sm" onclick="deleteData('{{ route('admin.material.destroy', $material) }}')" title="Hapus">
        <i class="fa fa-trash"></i>
    </button>
</div>