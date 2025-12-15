<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="dns-prefetch" href="//fonts.bunny.net">

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom-dashboard.css') }}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="font-sans antialiased error-page">
    <!-- Floating background shapes -->
    <div class="floating-shapes"></div>
    
    <!-- Modern Header -->
    <header class="modern-header">
        <nav class="modern-nav">
            <a href="{{ url('/') }}" class="logo-modern">
                <x-application-mark class="block h-9 w-auto" />
                <span>{{ config('app.name', 'Laravel') }}</span>
            </a>
            
            <div class="header-actions">
                <a href="{{ url('/') }}" class="btn-modern btn-sm">
                    <i class="fas fa-home"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </nav>
    </header>

    <!-- Error Content -->
    <main class="error-container">
        @yield('content')
    </main>

    <!-- Back to top button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <script>
        // Back to top functionality
        const backToTop = document.getElementById('backToTop');
        if (backToTop) {
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            });

            backToTop.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Add floating animation to error illustration
        document.addEventListener('DOMContentLoaded', function() {
            const errorIllustration = document.querySelector('.error-illustration');
            if (errorIllustration) {
                setTimeout(() => {
                    errorIllustration.style.animation = 'float 3s ease-in-out infinite';
                }, 1000);
            }
        });
    </script>
</body>
</html>