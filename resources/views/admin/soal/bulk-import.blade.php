@extends('layouts/admin/app')

@section('title')
Bulk Import Soal - {{ $ujian->nama }}
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="{{ route('admin.ujian.index') }}">Ujian</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.ujian.soal.index', $ujian->id) }}">Soal {{ $ujian->nama }}</a></li>
<li class="breadcrumb-item active">Bulk Import</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Import Soal Secara Massal</h3>
                </div>
                <div class="card-body">
                    <!-- Alert Info -->
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-info"></i> Panduan Format Import</h5>
                        <p>Gunakan format berikut untuk import soal secara massal. Pisahkan setiap soal dengan tanda <code>===</code></p>
                    </div>

                    <!-- Format Guide Card -->
                    <div class="card card-outline card-primary mb-3">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-book"></i> Format Standar</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <pre class="bg-light p-3" style="border-radius: 5px; font-size: 12px;">@if($ujian->jenis_ujian == 'skd')<strong>JENIS_SOAL:</strong> TWK|TIU|TKP
@endif<strong>SOAL:</strong> Teks soal Anda di sini

<strong>A.</strong> Pilihan jawaban A
<strong>B.</strong> Pilihan jawaban B
<strong>C.</strong> Pilihan jawaban C
<strong>D.</strong> Pilihan jawaban D
<strong>E.</strong> Pilihan jawaban E
@if($ujian->jenis_ujian == 'skd')
<strong>KUNCI:</strong> A (untuk TWK/TIU) atau kosongkan untuk TKP
<strong>POINT_A:</strong> 5 (khusus TKP)
<strong>POINT_B:</strong> 4 (khusus TKP)
<strong>POINT_C:</strong> 3 (khusus TKP)
<strong>POINT_D:</strong> 2 (khusus TKP)
<strong>POINT_E:</strong> 1 (khusus TKP)
@else
<strong>KUNCI:</strong> A
@endif
<strong>NILAI_BENAR:</strong> 5
<strong>NILAI_SALAH:</strong> 0
<strong>NILAI_KOSONG:</strong> 0
<strong>PEMBAHASAN:</strong> Penjelasan pembahasan soal (opsional)

<strong>===</strong> (pemisah antar soal)</pre>
                        </div>
                    </div>

                    <!-- Contoh Soal Card -->
                    <div class="card card-outline card-success mb-3">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-lightbulb"></i> Contoh Import</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <pre class="bg-light p-3" style="border-radius: 5px; font-size: 12px;">@if($ujian->jenis_ujian == 'skd')JENIS_SOAL: TWK
@endifSOAL: Pancasila sebagai dasar negara Indonesia disahkan pada tanggal?

A. 17 Agustus 1945
B. 18 Agustus 1945
C. 1 Juni 1945
D. 22 Juni 1945
E. 5 Juli 1945

KUNCI: B
NILAI_BENAR: 5
NILAI_SALAH: 0
NILAI_KOSONG: 0
PEMBAHASAN: Pancasila disahkan sebagai dasar negara pada tanggal 18 Agustus 1945.

===
@if($ujian->jenis_ujian == 'skd')
JENIS_SOAL: TKP
SOAL: Ketika menghadapi konflik dengan rekan kerja, sikap saya adalah...

A. Menghindari konflik dan tidak bicara lagi
B. Meminta maaf terlebih dahulu meski bukan salah saya
C. Mengajak diskusi untuk mencari solusi bersama
D. Melaporkan ke atasan
E. Membiarkan waktu yang menyelesaikan

POINT_A: 1
POINT_B: 3
POINT_C: 5
POINT_D: 2
POINT_E: 1
PEMBAHASAN: Mengajak diskusi untuk mencari solusi bersama menunjukkan sikap dewasa dan profesional.

===
@endifSOAL: Ibu kota Indonesia adalah...

A. Jakarta
B. Bandung
C. Surabaya
D. Medan
E. Yogyakarta

KUNCI: A
NILAI_BENAR: 5
NILAI_SALAH: 0
NILAI_KOSONG: 0
PEMBAHASAN: Jakarta adalah ibu kota negara Indonesia.</pre>
                        </div>
                    </div>

                    <!-- Form Import -->
                    <form action="{{ route('admin.ujian.soal.bulk-import.store', $ujian->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="bulk_data">Paste Soal di Sini <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control @error('bulk_data') is-invalid @enderror" 
                                name="bulk_data" 
                                id="bulk_data" 
                                rows="20" 
                                placeholder="Paste soal Anda sesuai format di atas..."
                                required>{{ old('bulk_data') }}</textarea>
                            @error('bulk_data')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                Paste soal dengan format yang telah ditentukan. Pastikan setiap soal dipisahkan dengan <code>===</code>
                            </small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="skip_errors" name="skip_errors" value="1" checked>
                                <label class="custom-control-label" for="skip_errors">
                                    Lewati soal yang error dan lanjutkan import (direkomendasikan)
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('admin.ujian.soal.index', $ujian->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Import Soal
                                </button>
                            </div>
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
    @if(Session::has('success'))
    toastr.options = {
        "positionClass": "toast-bottom-right",
        "closeButton": true,
        "progressBar": true
    }
    toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
    toastr.options = {
        "positionClass": "toast-bottom-right",
        "closeButton": true,
        "progressBar": true
    }
    toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options = {
        "positionClass": "toast-bottom-right",
        "closeButton": true,
        "progressBar": true
    }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>
@endpush