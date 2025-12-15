@extends('layouts/admin/app')

@section('title')
    Manajemen Materi
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Materi</li>
@endsection

@section('content')
<section id="materials" class="materials">
    <div class="container-fluid" data-aos="fade-up">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-3">Manajemen Materi</h2>
                    <p class="text-muted">Kelola semua materi pembelajaran di platform</p>
                </div>
                <button onclick="addForm('{{ route('admin.material.store') }}')" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Tambah Materi
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.material.index') }}">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label">Tutor</label>
                                <select name="tutor_id" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ request('tutor_id') == 'all' ? 'selected' : '' }}>Semua Tutor</option>
                                    @foreach($tutors as $tutor)
                                        <option value="{{ $tutor->id }}" {{ request('tutor_id') == $tutor->id ? 'selected' : '' }}>
                                            {{ $tutor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tipe Materi</label>
                                <select name="type" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                                    <option value="youtube" {{ request('type') == 'youtube' ? 'selected' : '' }}>Video YouTube</option>
                                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                                    <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Dokumen</option>
                                    <option value="link" {{ request('type') == 'link' ? 'selected' : '' }}>Link</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Visibilitas</label>
                                <select name="visibility" class="form-select" onchange="this.form.submit()">
                                    <option value="" {{ request('visibility') == '' ? 'selected' : '' }}>Semua</option>
                                    <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Publik</option>
                                    <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Privat</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Paket</label>
                                <select name="batch_id" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ request('batch_id') == 'all' ? 'selected' : '' }}>Semua Paket</option>
                                    @foreach($paketUjians as $paket)
                                        <option value="{{ $paket->id }}" {{ request('batch_id') == $paket->id ? 'selected' : '' }}>
                                            {{ $paket->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Cari</label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari materi..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($materials->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                        <h5>Belum Ada Materi</h5>
                        <p class="text-muted">
                            Belum ada materi yang ditambahkan ke dalam sistem.
                        </p>
                        <button onclick="addForm('{{ route('admin.material.store') }}')" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Tambah Materi Pertama
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($materials as $material)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 material-card">
                        <div class="material-thumbnail">
                            @if($material->type === 'youtube' && $material->youtube_url)
                                <img src="{{ $material->getYoutubeThumbnail() }}" alt="{{ $material->title }}" class="card-img-top">
                                <div class="play-overlay">
                                    <i class="fab fa-youtube fa-3x"></i>
                                </div>
                            @elseif($material->thumbnail_path)
                                <img src="{{ asset('storage/' . $material->thumbnail_path) }}" alt="{{ $material->title }}" class="card-img-top">
                            @else
                                <div class="placeholder-thumbnail">
                                    <i class="{{ $material->getTypeIcon() }} fa-4x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ ucfirst($material->type) }}</span>
                                @if($material->is_featured)
                                    <span class="badge bg-warning">Unggulan</span>
                                @endif
                                @if($material->is_public)
                                    <span class="badge bg-success">Publik</span>
                                @else
                                    <span class="badge bg-secondary">Privat</span>
                                @endif
                                @if($material->batch)
                                    <span class="badge bg-info">{{ $material->batch->nama }}</span>
                                @endif
                            </div>
                            <h5 class="card-title">{{ Str::limit($material->title, 60) }}</h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit($material->description, 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-eye"></i> {{ number_format($material->views_count) }} views
                                </small>
                                @if($material->duration_seconds)
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $material->getFormattedDuration() }}
                                    </small>
                                @endif
                            </div>
                            @if($material->tutor)
                                <small class="text-muted">
                                    <i class="fas fa-user"></i> {{ $material->tutor->name }}
                                </small>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <button onclick="showForm('{{ route('admin.material.show', $material) }}')" class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>
                                <button onclick="editForm('{{ route('admin.material.edit', $material) }}')" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteData('{{ route('admin.material.destroy', $material) }}')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                {{ $materials->links() }}
            </div>
        </div>
    @endif
    </div>
</section>

@includeIf('admin.material.form')
@includeIf('admin.material.show')

@endsection

@push('styles')
<style>
.material-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.material-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.material-thumbnail {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
}

.material-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-thumbnail {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.play-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.material-card:hover .play-overlay {
    opacity: 1;
}

.card-body {
    padding: 1.25rem;
}

.card-body .badge {
    font-size: 0.75rem;
    margin-right: 0.25rem;
    margin-bottom: 0.25rem;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    color: #2c3e50;
}

.card-text {
    margin-bottom: 1rem;
    line-height: 1.5;
    color: #6c757d;
}

.card-body .d-flex {
    margin-bottom: 0.75rem;
}

.card-body .d-flex small {
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.card-body small.text-muted {
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.card-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding: 0.75rem 1.25rem;
}

.card-footer .btn {
    font-size: 0.85rem;
    padding: 0.5rem 0.75rem;
}
</style>
@endpush

@push('scripts')
    <script>
        $(function () {
            // Form submission
            $('#modal-form form').on('submit', function (e) {
                e.preventDefault();

                // Create FormData for file uploads
                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal-form').modal('hide');
                        // Show success notification
                        toastr.success(response.message || 'Materi berhasil disimpan!');
                        // Reload the page to show updated data
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500); // Delay reload to show notification
                    },
                    error: function(xhr) {
                        console.log('Errors:', xhr);
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Handle validation errors
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = [];
                            for (let field in errors) {
                                errorMessages.push(errors[field].join(', '));
                            }
                            toastr.error('Validation Error: ' + errorMessages.join('; '));
                        } else {
                            toastr.error('Terjadi kesalahan saat menyimpan data.');
                        }
                    }
                });
            });
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Materi');

            $('#modal-form form')[0].classList.remove('was-validated');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');

            // Reset checkboxes to default values
            $('#modal-form [name=is_completable]').prop('checked', true);

            // Explicitly set button text for add mode
            $('#modal-form button[type=submit]').text('Simpan');

            $('#modal-form [name=title]').focus();
        }

        function editForm(url) {
            $.get(url)
                .done((response) => {
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Materi');

                    $('#modal-form form')[0].classList.remove('was-validated');
                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('put');

                    // Fill form fields
                    $('#modal-form [name=title]').val(response.title);
                    $('#modal-form [name=tutor_id]').val(response.tutor_id);
                    $('#modal-form [name=batch_id]').val(response.batch_id);
                    $('#modal-form [name=mapel]').val(response.mapel);
                    $('#modal-form [name=description]').val(response.description);
                    $('#modal-form [name=type]').val(response.type);
                    $('#modal-form [name=youtube_url]').val(response.youtube_url);
                    $('#modal-form [name=external_link]').val(response.external_link);
                    $('#modal-form [name=content]').val(response.content);
                    $('#modal-form [name=duration_seconds]').val(response.duration_seconds);
                    $('#modal-form [name=chapter_number]').val(response.chapter_number);
                    $('#modal-form [name=chapter_title]').val(response.chapter_title);
                    $('#modal-form [name=material_order]').val(response.material_order);

                    // Handle tags
                    if (response.tags && Array.isArray(response.tags)) {
                        $('#modal-form [name=tags]').val(response.tags.join(', '));
                    } else if (response.tags) {
                        $('#modal-form [name=tags]').val(response.tags);
                    }

                    // Checkboxes
                    $('#modal-form [name=is_public]').prop('checked', response.is_public);
                    $('#modal-form [name=is_featured]').prop('checked', response.is_featured);
                    $('#modal-form [name=is_completable]').prop('checked', response.is_completable);

                    // Show/hide type-specific fields
                    toggleTypeFields();

                    // Set button text for edit mode
                    $('#modal-form button[type=submit]').text('Update');

                    $('#modal-form [name=title]').focus();
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data.');
                    return;
                });
        }

        function showForm(url) {
            $.get(url)
                .done((response) => {
                    $('#modal-show').modal('show');
                    $('#modal-show .modal-title').text('Detail Materi');

                    let html = `
                        <div class="row">
                            <div class="col-md-12">
                                <h5>${response.title}</h5>
                                <hr>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Tutor:</strong></td>
                                        <td>${response.tutor ? response.tutor.name : 'Belum Ditentukan'}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Paket:</strong></td>
                                        <td>${response.batch ? response.batch.nama : 'N/A'}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis:</strong></td>
                                        <td>${response.type}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Visibilitas:</strong></td>
                                        <td>${response.is_public ? 'Publik' : 'Privat'}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>${response.is_featured ? 'Unggulan' : 'Normal'}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td>${new Date(response.created_at).toLocaleString('id-ID')}</td>
                                    </tr>
                                    ${response.description ? `
                                    <tr>
                                        <td><strong>Deskripsi:</strong></td>
                                        <td>${response.description}</td>
                                    </tr>
                                    ` : ''}
                                </table>
                            </div>
                        </div>
                    `;

                    $('#modal-show .modal-body').html(html);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data.');
                    return;
                });
        }

        function deleteData(url) {
            Swal.fire({
                title: 'Apakah Anda yakin akan menghapus data ini?',
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
                            // Reload the page to show updated data
                            window.location.reload();
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
            });
        }

        function toggleFeatured(url) {
            $.post(url, {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                '_method': 'post'
            })
                .done((response) => {
                    // Reload the page to show updated data
                    window.location.reload();
                })
                .fail((xhr) => {
                    let errorMessage = 'Tidak dapat mengubah status.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    toastr.error(errorMessage);
                    console.error('Toggle error:', xhr);
                });
        }

        function togglePublic(url) {
            $.post(url, {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                '_method': 'post'
            })
                .done((response) => {
                    // Reload the page to show updated data
                    window.location.reload();
                })
                .fail((xhr) => {
                    let errorMessage = 'Tidak dapat mengubah visibilitas.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    toastr.error(errorMessage);
                    console.error('Toggle error:', xhr);
                });
        }

        function toggleTypeFields() {
            const type = $('#modal-form [name=type]').val();
            const fileField = $('#fileField');
            const youtubeField = $('#youtubeField');
            const linkField = $('#linkField');

            // Hide all type-specific fields
            fileField.hide();
            youtubeField.hide();
            linkField.hide();

            // Show relevant field based on type
            if (type === 'video' || type === 'document') {
                fileField.show();
            } else if (type === 'youtube') {
                youtubeField.show();
            } else if (type === 'link') {
                linkField.show();
            }
        }

        // Event listener for type change
        $(document).on('change', '#modal-form [name=type]', function() {
            toggleTypeFields();
        });

        // Auto-fill chapter title when chapter number changes
        $(document).on('input', '#modal-form [name=chapter_number]', function() {
            var chapterNum = $(this).val();
            var chapterTitleField = $('#modal-form [name=chapter_title]');
            if (chapterNum && !chapterTitleField.val()) {
                chapterTitleField.val('Bab ' + chapterNum);
            }
        });
    </script>
@endpush