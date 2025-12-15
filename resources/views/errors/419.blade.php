@extends('errors.layout')

@section('title', 'Sesi Habis')

@section('content')
<div class="error-page-wrapper">
    <div class="container">
        <div class="error-content">
            <!-- Error Illustration -->
            <div class="error-illustration">
                <div class="error-number">419</div>
                <div class="error-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>

            <!-- Error Details -->
            <div class="glass-card error-details">
                <div class="error-header">
                    <h1 class="error-title">Sesi Habis</h1>
                    <p class="error-subtitle">Sesi Anda telah berakhir. Harap muat ulang halaman dan coba lagi.</p>
                </div>

                <div class="error-description">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>CSRF Token Expired</strong>
                            <p>Untuk keamanan, sesi Anda telah berakhir setelah periode tertentu tidak ada aktivitas.</p>
                        </div>
                    </div>
                    
                    <p><strong>Yang terjadi:</strong></p>
                    <ul>
                        <li>Sesi login Anda telah berakhir</li>
                        <li>Halaman perlu dimuat ulang untuk keamanan</li>
                        <li>Form yang sedang diisi perlu dikirm ulang</li>
                        <li>Data yang belum tersimpan mungkin hilang</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="error-actions">
                    <button onclick="location.reload()" class="btn-modern">
                        <i class="fas fa-sync-alt"></i>
                        Muat Ulang Halaman
                    </button>
                    <a href="{{ url('/') }}" class="btn-secondary">
                        <i class="fas fa-home"></i>
                        Kembali ke Beranda
                    </a>
                </div>

                <!-- Prevention Tips -->
                <div class="tips-info">
                    <h3>Tips Menghindari Error Ini:</h3>
                    <div class="tips-list">
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Simpan pekerjaan secara berkala</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Hindari membiarkan halaman terbuka terlalu lama</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Jangan refresh halaman saat mengisi form</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Selalu submit form dengan cepat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection