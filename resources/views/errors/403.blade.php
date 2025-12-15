@extends('errors.layout')

@section('title', 'Akses Ditolak')

@section('content')
<div class="error-page-wrapper">
    <div class="container">
        <div class="error-content">
            <!-- Error Illustration -->
            <div class="error-illustration">
                <div class="error-number">403</div>
                <div class="error-icon">
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <!-- Error Details -->
            <div class="glass-card error-details">
                <div class="error-header">
                    <h1 class="error-title">Akses Ditolak</h1>
                    <p class="error-subtitle">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                </div>

                <div class="error-description">
                    <div class="alert alert-danger">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <strong>Area Terbatas</strong>
                            <p>Halaman ini memerlukan izin khusus atau level akses yang lebih tinggi.</p>
                        </div>
                    </div>
                    
                    <p><strong>Kemungkinan penyebab:</strong></p>
                    <ul>
                        <li>Anda belum login ke akun Anda</li>
                        <li>Akun Anda tidak memiliki akses ke fitur ini</li>
                        <li>Sesi login Anda telah berakhir</li>
                        <li>Anda mencoba mengakses area admin tanpa izin</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="error-actions">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-modern">
                            <i class="fas fa-tachometer-alt"></i>
                            Ke Dashboard
                        </a>
                        <a href="{{ route('profile.show') }}" class="btn-secondary">
                            <i class="fas fa-user"></i>
                            Lihat Profil
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-modern">
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-secondary">
                            <i class="fas fa-user-plus"></i>
                            Daftar
                        </a>
                    @endauth
                </div>

                <!-- Help Section -->
                <div class="help-info">
                    <h3>Perlu Bantuan?</h3>
                    <p>Jika Anda yakin seharusnya memiliki akses ke halaman ini:</p>
                    <div class="help-actions">
                        <a href="{{ route('dashboard') }}" class="help-link">
                            <i class="fas fa-home"></i>
                            Kembali ke Dashboard
                        </a>
                        <a href="mailto:padilzaki73@gmail.com" class="help-link">
                            <i class="fas fa-envelope"></i>
                            Hubungi Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection