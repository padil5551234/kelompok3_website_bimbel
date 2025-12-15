{{-- Determine if we're in edit mode --}}
@php
    $isEdit = isset($material) && !request()->has('mode');
@endphp

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-formLabel">Form Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" method="POST" action="" novalidate>
                @csrf
                <input type="hidden" name="_method" value="{{ $isEdit ? 'put' : 'post' }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Judul Materi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" id="title" 
                                       value="{{ $isEdit ? $material->title : old('title') }}" required>
                                <div class="invalid-feedback">Judul materi wajib diisi.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mapel">Mata Pelajaran</label>
                                <input type="text" class="form-control" name="mapel" id="mapel" 
                                       value="{{ $isEdit ? $material->mapel : old('mapel') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tutor_id">Tutor <span class="text-danger">*</span></label>
                                <select class="form-control" name="tutor_id" id="tutor_id" required>
                                    <option value="">Pilih Tutor</option>
                                    @foreach($tutors as $tutor)
                                        <option value="{{ $tutor->id }}"
                                            {{ $isEdit && $material->tutor_id == $tutor->id ? 'selected' : '' }}>
                                            {{ $tutor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Tutor wajib dipilih.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="batch_id">Paket Ujian <span class="text-danger">*</span></label>
                                <select class="form-control" name="batch_id" id="batch_id" required>
                                    <option value="">Pilih Paket</option>
                                    @foreach($paketUjians as $paket)
                                        <option value="{{ $paket->id }}"
                                            {{ $isEdit && $material->batch_id == $paket->id ? 'selected' : '' }}>
                                            {{ $paket->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Paket ujian wajib dipilih.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Chapter Information -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="chapter_number">Nomor Bab</label>
                                <input type="number" class="form-control" name="chapter_number" id="chapter_number"
                                       min="1" value="{{ $isEdit ? $material->chapter_number : old('chapter_number') }}"
                                       placeholder="1">
                                <small class="form-text text-muted">Nomor bab dalam paket (opsional)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="chapter_title">Judul Bab</label>
                                <input type="text" class="form-control" name="chapter_title" id="chapter_title"
                                       value="{{ $isEdit ? $material->chapter_title : old('chapter_title') }}"
                                       placeholder="Bab 1: Pengenalan">
                                <small class="form-text text-muted">Judul bab (opsional)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="material_order">Urutan Materi</label>
                                <input type="number" class="form-control" name="material_order" id="material_order"
                                       min="0" value="{{ $isEdit ? $material->material_order : old('material_order', 0) }}"
                                       placeholder="0">
                                <small class="form-text text-muted">Urutan dalam bab (0 = default)</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type">Jenis Materi <span class="text-danger">*</span></label>
                        <select class="form-control" name="type" id="type" required>
                            <option value="">Pilih Jenis</option>
                            <option value="video" {{ $isEdit && $material->type == 'video' ? 'selected' : '' }}>Video</option>
                            <option value="document" {{ $isEdit && $material->type == 'document' ? 'selected' : '' }}>Dokumen</option>
                            <option value="link" {{ $isEdit && $material->type == 'link' ? 'selected' : '' }}>Link Eksternal</option>
                            <option value="youtube" {{ $isEdit && $material->type == 'youtube' ? 'selected' : '' }}>YouTube</option>
                        </select>
                        <div class="invalid-feedback">Jenis materi wajib dipilih.</div>
                    </div>

                    <div class="form-group" id="fileField" style="display: none;">
                        <label for="file">File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" name="file" id="file">
                        @if($isEdit && $material->file_path)
                            <small class="form-text text-muted">
                                File saat ini: <a href="{{ Storage::url($material->file_path) }}" target="_blank">Download</a>
                            </small>
                        @endif
                        <small class="form-text text-muted">
                            Upload file video (mp4, avi, mov, wmv) atau dokumen (pdf, doc, docx). Maksimal 100MB.
                        </small>
                    </div>

                    <div class="form-group" id="youtubeField" style="display: none;">
                        <label for="youtube_url">URL YouTube <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" name="youtube_url" id="youtube_url" 
                               value="{{ $isEdit ? $material->youtube_url : old('youtube_url') }}" 
                               placeholder="https://www.youtube.com/watch?v=...">
                        <small class="form-text text-muted">Masukkan URL video YouTube yang valid.</small>
                    </div>

                    <div class="form-group" id="linkField" style="display: none;">
                        <label for="external_link">Link Eksternal <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" name="external_link" id="external_link" 
                               value="{{ $isEdit ? $material->external_link : old('external_link') }}" 
                               placeholder="https://...">
                        <small class="form-text text-muted">Masukkan URL eksternal yang valid.</small>
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" name="description" id="description" rows="3" 
                                  placeholder="Deskripsi materi...">{{ $isEdit ? $material->description : old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="content">Konten</label>
                        <textarea class="form-control" name="content" id="content" rows="5" 
                                  placeholder="Konten atau teks materi...">{{ $isEdit ? $material->content : old('content') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="thumbnail">Thumbnail</label>
                                <input type="file" class="form-control-file" name="thumbnail" id="thumbnail" accept="image/*">
                                @if($isEdit && $material->thumbnail_path)
                                    <small class="form-text text-muted">
                                        Thumbnail saat ini: <a href="{{ Storage::url($material->thumbnail_path) }}" target="_blank">Lihat</a>
                                    </small>
                                @endif
                                <small class="form-text text-muted">Upload thumbnail (jpg, png, gif). Maksimal 2MB.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="duration_seconds">Durasi (detik)</label>
                                <input type="number" class="form-control" name="duration_seconds" id="duration_seconds" 
                                       min="1" value="{{ $isEdit ? $material->duration_seconds : old('duration_seconds') }}" 
                                       placeholder="3600">
                                <small class="form-text text-muted">Durasi dalam detik (opsional).</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <input type="text" class="form-control" name="tags" id="tags" 
                               value="{{ $isEdit ? (is_array($material->tags) ? implode(', ', $material->tags) : $material->tags) : old('tags') }}" 
                               placeholder="tag1, tag2, tag3">
                        <small class="form-text text-muted">Pisahkan dengan koma.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_public" id="is_public" value="1"
                                       {{ $isEdit && $material->is_public ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_public">
                                    Materi Publik
                                </label>
                                <small class="form-text text-muted">Centang jika materi dapat diakses oleh semua user.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_featured" id="is_featured" value="1"
                                       {{ $isEdit && $material->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Materi Unggulan
                                </label>
                                <small class="form-text text-muted">Centang jika materi ditampilkan sebagai unggulan.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_completable" id="is_completable" value="1"
                                       {{ $isEdit ? ($material->is_completable ? 'checked' : '') : 'checked' }}>
                                <label class="form-check-label" for="is_completable">
                                    Dapat Ditandai Selesai
                                </label>
                                <small class="form-text text-muted">Centang jika user dapat menandai materi ini sebagai selesai.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Initialize form with current values if in edit mode --}}
@push('scripts')

{{-- Chapter Number Enhancement --}}
<script>
$(document).ready(function() {
    // Auto-suggest next chapter number when batch is selected
    $("#batch_id").on("change", function() {
        const batchId = $(this).val();
        if (batchId) {
            $.get("/admin/material/next-chapter/" + batchId, function(data) {
                if (data.next_chapter) {
                    $("#chapter_number").attr("placeholder", "Next: " + data.next_chapter);
                }
            }).fail(function() {
                $("#chapter_number").attr("placeholder", "1");
            });
        } else {
            $("#chapter_number").attr("placeholder", "1");
        }
    });
    
    // Show suggestion tooltip when chapter field is focused
    $("#chapter_number").on("focus", function() {
        const batchId = $("#batch_id").val();
        const currentValue = $(this).val();
        
        if (!currentValue && batchId) {
            $.get("/admin/material/next-chapter/" + batchId, function(data) {
                if (data.next_chapter && !$("#chapter_number").val()) {
                    $(this).attr("title", "Suggested: " + data.next_chapter);
                }
            }.bind(this)).fail(function() {
                $(this).attr("title", "Leave empty for auto-assignment");
            }.bind(this));
        }
    });
    
    // Clear suggestion when user types
    $("#chapter_number").on("input", function() {
        $(this).removeAttr("title");
    });
});
</script>

@if($isEdit)
<script>
$(document).ready(function() {
    // Set initial values for edit mode
    @php
    echo "    $('#modal-form [name=title]').val('" . addslashes($material->title) . "');\n";
    echo "    $('#modal-form [name=mapel]').val('" . addslashes($material->mapel) . "');\n";
    echo "    $('#modal-form [name=tutor_id]').val('" . $material->tutor_id . "');\n";
    echo "    $('#modal-form [name=batch_id]').val('" . $material->batch_id . "');\n";
    echo "    $('#modal-form [name=type]').val('" . $material->type . "');\n";
    echo "    $('#modal-form [name=youtube_url]').val('" . addslashes($material->youtube_url) . "');\n";
    echo "    $('#modal-form [name=external_link]').val('" . addslashes($material->external_link) . "');\n";
    echo "    $('#modal-form [name=description]').val('" . addslashes($material->description) . "');\n";
    echo "    $('#modal-form [name=content]').val('" . addslashes($material->content) . "');\n";
    echo "    $('#modal-form [name=duration_seconds]').val('" . $material->duration_seconds . "');\n";
    echo "    $('#modal-form [name=chapter_number]').val('" . $material->chapter_number . "');\n";
    echo "    $('#modal-form [name=chapter_title]').val('" . addslashes($material->chapter_title) . "');\n";
    echo "    $('#modal-form [name=material_order]').val('" . $material->material_order . "');\n";
    echo "    $('#modal-form [name=is_public]').prop('checked', " . ($material->is_public ? 'true' : 'false') . ");\n";
    echo "    $('#modal-form [name=is_featured]').prop('checked', " . ($material->is_featured ? 'true' : 'false') . ");\n";
    echo "    $('#modal-form [name=is_completable]').prop('checked', " . ($material->is_completable ? 'true' : 'false') . ");\n";
    @endphp
    
    // Show/hide type-specific fields
    toggleTypeFields();
});
</script>
@endif
@endpush