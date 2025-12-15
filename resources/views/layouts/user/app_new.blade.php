<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title') &mdash; {{ config('app.name', 'Laravel') }}</title>
    <meta content="Website Tryout Online dengan Design Modern" name="description">
    <meta content="Tryout Online, Bimbingan Kedinasan, Ujian Online" name="keywords">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom-dashboard.css') }}">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/plugins/toastr/toastr.min.css">

    @stack('styles')
</head>

<body>
    <!-- Modern Header -->
    <header class="modern-header" id="header">
        <nav class="modern-nav">
            <a href="{{ route('dashboard') }}" class="logo-modern">
                <img src="{{ asset('img/logo.png') }}" alt="Logo Bimbel">
                <span>{{ config('app.name', 'Laravel') }}</span>
            </a>

            <ul class="nav-links" id="navLinks">
                <li><a href="{{ route('dashboard') }}">Home</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#pricing">Paket</a></li>
                <li><a href="{{ route('faq.index') }}">FAQ</a></li>
                <li><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                
                @auth
                    @if(auth()->user()->hasRole('tutor'))
                        <li><a href="{{ route('tutor.dashboard') }}">Dashboard Tutor</a></li>
                    @endif
                    
                    @if(auth()->user()->hasRole('admin'))
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                    @endif
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu glass-card" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="fas fa-user"></i> Profil
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('pembelian.index') }}">
                                <i class="fas fa-shopping-cart"></i> Pembelian
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('ranking.global') }}">
                                <i class="fas fa-trophy"></i> Peringkat Global
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('progres.nilai') }}">
                                <i class="fas fa-chart-line"></i> Grafik Progres
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('raport.index') }}">
                                <i class="fas fa-graduation-cap"></i> Raport Belajar
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="btn-modern btn-sm">Login</a></li>
                    <li><a href="{{ route('register') }}" class="btn-modern btn-secondary btn-sm">Daftar</a></li>
                @endauth
            </ul>

            <!-- Mobile menu toggle -->
            <div class="mobile-menu-toggle" id="mobileToggle">
                <i class="fas fa-bars"></i>
            </div>
        </nav>

        <!-- Mobile Navigation Menu -->
        <div class="mobile-nav glass-card" id="mobileNav">
            <ul class="mobile-nav-links">
                <li><a href="{{ route('dashboard') }}">Home</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#pricing">Paket</a></li>
                <li><a href="{{ route('faq.index') }}">FAQ</a></li>
                <li><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                
                @auth
                    @if(auth()->user()->hasRole('tutor'))
                        <li><a href="{{ route('tutor.dashboard') }}"><i class="fas fa-chalkboard-teacher"></i> Dashboard Tutor</a></li>
                    @endif
                    
                    @if(auth()->user()->hasRole('admin'))
                        <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-cogs"></i> Dashboard Admin</a></li>
                    @endif
                    
                    <!-- User Account Section - All items directly visible -->
                    <li class="user-section">
                        <div class="user-info">
                            <i class="fas fa-user-circle"></i>
                            {{ auth()->user()->name }}
                        </div>
                        <a href="{{ route('profile.show') }}" class="user-menu-item">
                            <i class="fas fa-user"></i> Profil
                        </a>
                        <a href="{{ route('pembelian.index') }}" class="user-menu-item">
                            <i class="fas fa-shopping-cart"></i> Pembelian
                        </a>
                        <a href="{{ route('ranking.global') }}" class="user-menu-item">
                            <i class="fas fa-trophy"></i> Peringkat Global
                        </a>
                        <a href="{{ route('progres.nilai') }}" class="user-menu-item">
                            <i class="fas fa-chart-line"></i> Grafik Progres
                        </a>
                        <a href="{{ route('raport.index') }}" class="user-menu-item">
                            <i class="fas fa-graduation-cap"></i> Raport Belajar
                        </a>
                        <div class="logout-section">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="mobile-nav-btn">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="btn-modern btn-sm">Login</a></li>
                    <li><a href="{{ route('register') }}" class="btn-modern btn-secondary btn-sm">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </header>

    <!-- Main Content -->
    @yield('content')

    <!-- Modern Footer -->
    <footer class="modern-footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Bimbel">
                        <h3>DinasSolution</h3>
                    </div>
                    <p>Platform try out online terpercaya yang membantu para calon mahasiswa mempersiapkan berbagai ujian masuk perguruan tinggi dengan program Try Out dan Bimbingan yang berkualitas.</p>
                </div>

                <div class="footer-section">
                    <h4>Program Kami</h4>
                    <ul class="footer-links">
                        <li><a href="#">Live Class</a></li>
                        <li><a href="#">Try Out</a></li>
                        <li><a href="#">Materi Belajar</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Bantuan</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('faq.index') }}">FAQ</a></li>
                        <li><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                        <li><a href="#contact">Kontak</a></li>
                        <li><a href="/terms">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Hubungi Kami</h4>
                    <div class="contact-info">
                        <p><i class="fas fa-map-marker-alt"></i> Jalan Otto Iskandar Dinata 64C<br>Jakarta Timur, DKI Jakarta</p>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:padilzaki73@gmail.com">padilzaki73@gmail.com</a></p>
                    </div>
                    
                    <div class="social-links">
                        <a href="https://www.whatsapp.com/channel/0029Vb6tAJ97IUYPkGCzF43g" target="_blank" class="social-link">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://twitter.com/UKMBimbelSTIS" target="_blank" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.facebook.com/BimbelSTIS/" target="_blank" class="social-link">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/bocah_kedinasan/" target="_blank" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@BimbelStis" target="_blank" class="social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="copyright">
                    <p>&copy; 2025 DinasSolution. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <a href="#" class="back-to-top">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- Loading overlay -->
    <div id="preloader">
        <div class="preloader-content">
            <div class="logo-loader">
                <img src="{{ asset('img/logo.png') }}" alt="Loading...">
            </div>
            <div class="loading-text">Memuat...</div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminLTE') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    
    <!-- Toastr -->
    <script src="{{ asset('adminLTE') }}/plugins/toastr/toastr.min.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        // Enhanced Toastr configuration
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "timeOut": "5000",
            "extendedTimeOut": "2000",
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "slideDown",
            "hideMethod": "slideUp",
            "tapToDismiss": false
        };

        // Mobile menu toggle
        document.getElementById('mobileToggle').addEventListener('click', function() {
            const mobileNav = document.getElementById('mobileNav');
            const icon = this.querySelector('i');
            
            mobileNav.classList.toggle('show');
            
            if (mobileNav.classList.contains('show')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Back to top button
        const backToTop = document.querySelector('.back-to-top');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            setTimeout(() => {
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 300);
            }, 1000);
        });

        // Show success/error messages
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>

    @stack('scripts')
</body>
</html>