@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="error-page-wrapper">
    <div class="container">
        <div class="error-content">
            <!-- Error Illustration -->
            <div class="error-illustration">
                <div class="error-number">404</div>
                <div class="error-icon">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <!-- Error Details -->
            <div class="glass-card error-details">
                <div class="error-header">
                    <h1 class="error-title">Oops! Halaman Tidak Ditemukan</h1>
                    <p class="error-subtitle">Sepertinya halaman yang Anda cari tidak ada atau telah dipindahkan.</p>
                </div>

                <div class="error-description">
                    <p>Jangan khawatir! Hal ini bisa terjadi karena:</p>
                    <ul>
                        <li>URL yang Anda ketik mungkin salah</li>
                        <li>Halaman telah dipindahkan atau dihapus</li>
                        <li>Link yang Anda klik sudah expired</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="error-actions">
                    <a href="{{ url('/') }}" class="btn-modern">
                        <i class="fas fa-home"></i>
                        Kembali ke Beranda
                    </a>
                    <button onclick="history.back()" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </button>
                </div>

                <!-- Quick Links -->
                <div class="quick-links">
                    <h3>Atau coba akses halaman populer:</h3>
                    <div class="links-grid">
                        <a href="{{ route('dashboard') }}" class="quick-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('profile.show') }}" class="quick-link">
                            <i class="fas fa-user"></i>
                            <span>Profil</span>
                        </a>
                        <a href="{{ route('articles.index') }}" class="quick-link">
                            <i class="fas fa-newspaper"></i>
                            <span>Artikel</span>
                        </a>
                        <a href="{{ url('/#features') }}" class="quick-link">
                            <i class="fas fa-star"></i>
                            <span>Fitur</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection