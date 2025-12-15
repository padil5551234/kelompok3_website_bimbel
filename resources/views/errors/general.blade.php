@extends('errors.layout')

@section('title', 'Terjadi Kesalahan')

@section('content')
<div class="error-page-wrapper">
    <div class="container">
        <div class="error-content">
            <!-- Error Illustration -->
            <div class="error-illustration">
                <div class="error-number">{{ $statusCode ?? '500' }}</div>
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>

            <!-- Error Details -->
            <div class="glass-card error-details">
                <div class="error-header">
                    <h1 class="error-title">Terjadi Kesalahan</h1>
                    <p class="error-subtitle">Maaf, terjadi kesalahan yang tidak terduga. Tim kami telah diberi tahu dan sedang memperbaikinya.</p>
                </div>

                <div class="error-description">
                    @if(isset($exception) && $exception->getMessage())
                        <div class="alert alert-danger">
                            <i class="fas fa-bug"></i>
                            <div>
                                <strong>Detail Error:</strong>
                                <p>{{ $exception->getMessage() }}</p>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <strong>Kesalahan Tidak Dikenal</strong>
                                <p>Terjadi kesalahan yang tidak dapat diidentifikasi secara spesifik.</p>
                            </div>
                        </div>
                    @endif
                    
                    <p><strong>Yang dapat Anda lakukan:</strong></p>
                    <ul>
                        <li>Tunggu beberapa saat dan coba lagi</li>
                        <li>Refresh halaman dengan menekan F5</li>
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
                    <button onclick="history.back()" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </button>
                </div>

                <!-- Contact Support -->
                <div class="support-info">
                    <h3>Butuh Bantuan Segera?</h3>
                    <p>Jika masalah ini berulang atau sangat mengganggu, hubungi kami:</p>
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
                    <p style="font-size: 0.9rem; color: rgba(255, 255, 255, 0.6); margin-top: 1rem;">
                        Error Code: {{ $statusCode ?? '500' }} | {{ date('Y-m-d H:i:s') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection