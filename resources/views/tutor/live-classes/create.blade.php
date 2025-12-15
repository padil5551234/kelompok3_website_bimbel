@extends('layouts.admin.app')

@section('title', 'Buat Kelas Live')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('tutor.live-classes.index') }}">Kelas Live</a></li>
    <li class="breadcrumb-item active">Buat Kelas</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-video"></i> Buat Kelas Live Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tutor.live-classes.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="batch_id">Paket Ujian <span class="text-danger">*</span></label>
                            <select name="batch_id" id="batch_id" class="form-control @error('batch_id') is-invalid @enderror" required>
                                <option value="">Pilih paket ujian</option>
                                @foreach($paketUjians as $paket)
                                    <option value="{{ $paket->id }}" {{ old('batch_id') == $paket->id ? 'selected' : '' }}>
                                        {{ $paket->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('batch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">Judul Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                                   placeholder="Masukkan judul kelas" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Deskripsi kelas">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="platform">Platform <span class="text-danger">*</span></label>
                                    <select name="platform" id="platform" class="form-control @error('platform') is-invalid @enderror" required>
                                        <option value="">Pilih platform</option>
                                        <option value="zoom" {{ old('platform') == 'zoom' ? 'selected' : '' }}>Zoom</option>
                                        <option value="google_meet" {{ old('platform') == 'google_meet' ? 'selected' : '' }}>Google Meet</option>
                                        <option value="teams" {{ old('platform') == 'teams' ? 'selected' : '' }}>Microsoft Teams</option>
                                        <option value="other" {{ old('platform') == 'other' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('platform')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duration_minutes">Durasi (menit) <span class="text-danger">*</span></label>
                                    <input type="number" name="duration_minutes" id="duration_minutes" 
                                           class="form-control @error('duration_minutes') is-invalid @enderror" 
                                           min="15" max="480" value="{{ old('duration_minutes', 60) }}" required>
                                    @error('duration_minutes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="meeting_link">Link Meeting</label>
                            <input type="url" name="meeting_link" id="meeting_link" 
                                   class="form-control @error('meeting_link') is-invalid @enderror" 
                                   placeholder="https://zoom.us/j/..." value="{{ old('meeting_link') }}">
                            @error('meeting_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Link meeting dapat diisi nanti jika belum tersedia
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="meeting_password">Password Meeting</label>
                            <input type="text" name="meeting_password" id="meeting_password" 
                                   class="form-control @error('meeting_password') is-invalid @enderror" 
                                   placeholder="Password (opsional)" value="{{ old('meeting_password') }}">
                            @error('meeting_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="scheduled_at">Jadwal <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="scheduled_at" id="scheduled_at" 
                                           class="form-control @error('scheduled_at') is-invalid @enderror" 
                                           value="{{ old('scheduled_at') }}" required>
                                    @error('scheduled_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_participants">Maksimal Peserta</label>
                                    <input type="number" name="max_participants" id="max_participants" 
                                           class="form-control @error('max_participants') is-invalid @enderror" 
                                           min="1" max="1000" value="{{ old('max_participants', 100) }}" placeholder="100">
                                    @error('max_participants')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="materials">Materi Pembelajaran</label>
                            <textarea name="materials[]" id="materials" rows="3" class="form-control @error('materials') is-invalid @enderror" 
                                      placeholder="Daftar materi yang akan dibahas (pisahkan dengan enter)">{{ old('materials') ? implode("\n", old('materials')) : '' }}</textarea>
                            @error('materials')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Tuliskan materi yang akan dibahas, satu materi per baris
                            </small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="send_notification" name="send_notification" value="1" checked>
                                <label class="custom-control-label" for="send_notification">
                                    Kirim notifikasi ke peserta
                                </label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <a href="{{ route('tutor.live-classes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary float-right">
                                <i class="fas fa-save"></i> Simpan Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4><i class="fas fa-info-circle"></i> Panduan</h4>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li><strong>Jadwal:</strong> Pilih tanggal dan waktu yang sesuai untuk kelas live</li>
                        <li><strong>Platform:</strong> Pilih platform video conference yang akan digunakan</li>
                        <li><strong>Link Meeting:</strong> Dapat diisi nanti jika belum tersedia saat membuat kelas</li>
                        <li><strong>Durasi:</strong> Atur durasi kelas antara 15 menit hingga 8 jam</li>
                        <li><strong>Materi:</strong> Daftar topik yang akan dibahas dalam kelas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Set minimum datetime to now
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('scheduled_at').min = now.toISOString().slice(0,16);
    
    // Handle materials textarea to array
    $('#materials').on('blur', function() {
        var lines = $(this).val().split('\n').filter(line => line.trim() !== '');
        $(this).val(lines.join('\n'));
    });
});
</script>
@endpush