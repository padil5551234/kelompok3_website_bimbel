@extends('layouts.auth')

@section('title', 'Login')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('stisla/library/bootstrap-social/bootstrap-social.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: relative;
            padding: 40px 60px 40px 40px;
            background: url('{{ asset('img/login.png') }}') center/cover no-repeat fixed;
        }
        
        .login-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }
        
        /* Login Card */
        .login-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 380px;
            margin-right: 0;
        }
        
        .modern-login-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #000000;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            padding: 30px 35px;
        }
        
        .modern-form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .modern-form-group label {
            color: #7162ed;
            font-size: 11px;
            font-weight: 400;
            margin-bottom: 6px;
            display: block;
            font-family: 'Poppins', sans-serif;
        }
        
        .input-wrapper {
            position: relative;
            border-bottom: 2.5px solid #7162ed;
            padding-bottom: 3px;
            display: flex;
            align-items: center;
        }
        
        .modern-form-control {
            border: none;
            border-radius: 0;
            padding: 10px 0;
            font-size: 11px;
            width: 100%;
            background: transparent;
            font-family: 'Poppins', sans-serif;
            outline: none;
            flex: 1;
        }
        
        .modern-form-control:focus {
            outline: none;
            box-shadow: none;
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .password-wrapper .toggle-password {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7162ed;
            font-size: 16px;
            padding: 5px;
            display: none;
            background: transparent;
            border: none;
            outline: none;
        }

        .password-wrapper:hover .toggle-password,
        .password-wrapper .modern-form-control:focus ~ .toggle-password,
        .password-wrapper .modern-form-control:not(:placeholder-shown) ~ .toggle-password {
            display: block;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        
        .modern-checkbox {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .modern-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #ff0083;
            border: 2px solid #ff0083;
        }
        
        .modern-checkbox label {
            margin: 0;
            cursor: pointer;
            color: #ff0083;
            font-weight: 400;
            font-size: 10px;
            font-family: 'Lilita One', cursive;
            letter-spacing: 1px;
        }
        
        .modern-link {
            color: #ff0083;
            text-decoration: none;
            font-weight: 400;
            font-size: 10px;
            font-family: 'Lilita One', cursive;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .modern-link:hover {
            text-decoration: underline;
        }
        
        .modern-divider {
            position: relative;
            text-align: center;
            margin: 16px 0;
        }
        
        .modern-divider span {
            background: #ffffff;
            padding: 0 0.8rem;
            color: #000000;
            font-size: 10px;
            font-family: 'Poppins', sans-serif;
        }
        
        .modern-btn-login {
            background: #7162ed;
            border: none;
            border-radius: 5px;
            padding: 10px 28px;
            font-weight: 400;
            font-size: 20px;
            transition: all 0.3s ease;
            width: 130px;
            height: 42px;
            color: #ffffff;
            font-family: 'Lilita One', cursive;
            letter-spacing: 2px;
            cursor: pointer;
            display: block;
            margin: 0 auto 16px;
        }
        
        .modern-btn-login:hover {
            background: #5f4fd4;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(113, 98, 237, 0.4);
        }
        
        .modern-btn-google {
            background: #fbf0b4;
            border: none;
            border-radius: 5px;
            padding: 7px 18px;
            font-weight: 400;
            color: #000000;
            transition: all 0.3s ease;
            width: 140px;
            height: 28px;
            font-size: 10px;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin: 0 auto;
        }
        
        .modern-btn-google:hover {
            background: #f5e89d;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(251, 240, 180, 0.5);
        }
        
        .modern-btn-google .fab {
            font-size: 14px;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 10px;
            margin-top: 4px;
            display: block;
        }
        
        @media (max-width: 1024px) {
            .login-wrapper {
                padding: 30px 40px 30px 30px;
            }
            
            .login-content {
                max-width: 360px;
            }
        }
        
        @media (max-width: 768px) {
            .login-wrapper {
                justify-content: center;
                padding: 20px;
            }

            .login-content {
                margin-right: 0;
                max-width: 100%;
            }

            .modern-login-card {
                padding: 25px 28px;
            }
        }

        @media (max-width: 480px) {
            .modern-login-card {
                padding: 20px 22px;
            }

            .modern-btn-login {
                width: 120px;
                height: 38px;
                font-size: 18px;
            }

            .modern-btn-google {
                width: 130px;
                font-size: 9px;
            }
        }
    </style>
@endpush

@section('main')
    <div class="login-wrapper">
        <div class="login-content">
            <div class="modern-login-card">
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                    @csrf
                    
                    <div class="modern-form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <input 
                                id="email"
                                type="email"
                                value="{{ old('email') }}"
                                class="form-control modern-form-control"
                                name="email"
                                tabindex="1"
                                placeholder=" "
                                required
                                autofocus>
                        </div>
                        @if($errors->has('email'))
                            <span class="error-message">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="modern-form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper password-wrapper">
                            <input
                                id="password"
                                type="password"
                                class="form-control modern-form-control"
                                name="password"
                                tabindex="2"
                                placeholder=" "
                                required>
                            <button type="button" class="toggle-password">
                                <i class="far fa-eye" id="togglePassword"></i>
                            </button>
                        </div>
                        @if($errors->has('password'))
                            <span class="error-message">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="remember-forgot">
                        <div class="modern-checkbox">
                            <input 
                                type="checkbox"
                                id="remember_me"
                                name="remember"
                                tabindex="3">
                            <label for="remember_me">Remember me</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="modern-link">
                            Lupa password?
                        </a>
                    </div>

                    <button 
                        type="submit"
                        class="modern-btn-login"
                        tabindex="4">
                        Masuk
                    </button>

                    <div class="modern-divider">
                        <span>atau</span>
                    </div>
                    
                    <a 
                        href="{{ route('google.login') }}"
                        class="modern-btn-google"
                        tabindex="5">
                        <span class="fab fa-google"></span> Login with Google
                    </a>

                    <div class="login-link" style="text-align: center; margin-top: 16px;">
                        <span style="color: #000000; font-size: 10px; font-family: 'Poppins', sans-serif;">Belum memiliki akun? </span>
                        <a href="{{ route('register') }}" class="modern-link">Daftar sekarang</a>
                    </div>

                    <div class="dashboard-link" style="text-align: center; margin-top: 12px;">
                        <a href="{{ route('dashboard') }}" class="modern-link">Lihat Dashboard Utama</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const toggleButton = document.querySelector('.toggle-password');
        const password = document.querySelector('#password');

        if (toggleButton && password) {
            toggleButton.addEventListener('click', function(e) {
                e.preventDefault();
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                togglePassword.classList.toggle('fa-eye');
                togglePassword.classList.toggle('fa-eye-slash');
            });
        }

        // Show/hide toggle button based on input
        if (password) {
            password.addEventListener('input', function() {
                if (this.value.length > 0) {
                    toggleButton.style.display = 'block';
                } else {
                    toggleButton.style.display = 'none';
                }
            });
        }
    </script>
@endpush