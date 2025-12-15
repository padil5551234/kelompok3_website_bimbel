@extends('errors.layout')

@section('title', 'Server Error')

@section('content')
<div class="error-page-wrapper">
    <div class="container">
        <div class="error-content">
            <!-- Error Illustration -->
            <div class="error-illustration">
                <div class="error-number">500</div>
                <div class="error-icon">
                    <i class="fas fa-server"></i>
                </div>
            </div>

            <!-- Error Details -->
            <div class="glass-card error-details">
                <div class="error-header">
                    <h1 class="error-title">Oops! Terjadi Kesalahan Server</h1>
                    <p class="error-subtitle">Kami mengalami masalah teknis saat memproses permintaan Anda. Tim kami telah diberi tahu dan sedang memperbaikinya.</p>
                </div>

                <div class="error-description">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Apa yang terjadi?</strong>
                            <p>Terjadi kesalahan internal pada server. Ini bukan kesalahan dari pihak Anda.</p>
                        </div>
                    </div>
                    
                    <p><strong>Yang dapat Anda lakukan:</strong></p>
                    <ul>
                        <li>Tunggu beberapa saat dan coba lagi</li>
                        <li>Refresh halaman dengan menekan F5 atau Ctrl+R</li>
                        <li>Kosongkan cache browser Anda</li>
                        <li>Hubungi tim support jika masalah berlanjut</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="error-actions">
                    <button onclick="location.reload()" class="btn-modern">
                        <i class="fas fa-sync-alt"></i>
                        Coba Lagi
                    </button>
                    <a href="{{ url('/') }}" class="btn-secondary">
                        <i class="fas fa-home"></i>
                        Kembali ke Beranda
                    </a>
                </div>

                <!-- Contact Support -->
                <div class="support-info">
                    <h3>Butuh Bantuan?</h3>
                    <p>Jika masalah berlanjut, hubungi tim support kami:</p>
                    <div class="contact-methods">
                        <a href="mailto:padilzaki73@gmail.com" class="contact-method">
                            <i class="fas fa-envelope"></i>
                            <span>padilzaki73@gmail.com</span>
                        </a>
                        <a href="https://wa.me/6281234567890" class="contact-method" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp Support</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection