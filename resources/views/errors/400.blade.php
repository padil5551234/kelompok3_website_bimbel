@extends('errors.layout')

@section('title', 'Permintaan Tidak Valid')

@section('content')
<div class="error-page-wrapper">
    <div class="container">
        <div class="error-content">
            <!-- Error Illustration -->
            <div class="error-illustration">
                <div class="error-number">400</div>
                <div class="error-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            </div>

            <!-- Error Details -->
            <div class="glass-card error-details">
                <div class="error-header">
                    <h1 class="error-title">Permintaan Tidak Valid</h1>
                    <p class="error-subtitle">Sepertinya ada masalah dengan permintaan yang Anda kirimkan ke server.</p>
                </div>

                <div class="error-description">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Permintaan Bermasalah</strong>
                            <p>Server tidak dapat memproses permintaan Anda karena format atau konten yang tidak valid.</p>
                        </div>
                    </div>
                    
                    <p><strong>Kemungkinan penyebab:</strong></p>
                    <ul>
                        <li>Data yang dikirim tidak lengkap atau tidak valid</li>
                        <li>Parameter URL yang salah</li>
                        <li>Format file upload yang tidak didukung</li>
                        <li>Karakter khusus yang tidak diizinkan</li>
                        <li>Ukuran data yang terlalu besar</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="error-actions">
                    <button onclick="history.back()" class="btn-modern">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </button>
                    <a href="{{ url('/') }}" class="btn-secondary">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                </div>

                <!-- Tips Section -->
                <div class="tips-info">
                    <h3>Tips untuk Menghindari Error Ini:</h3>
                    <div class="tips-list">
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Pastikan semua field wajib telah diisi</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Gunakan format file yang didukung</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Periksa kembali URL yang Anda ketik</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Hapus karakter khusus yang tidak perlu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection