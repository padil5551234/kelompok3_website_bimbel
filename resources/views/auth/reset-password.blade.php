@extends('layouts.auth')

@section('title', 'Reset Password')

@push('style')
    <!-- CSS Libraries -->
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

        .reset-password-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: relative;
            padding: 0 60px 40px 40px;
            background: url('{{ asset('img/login.png') }}') center/cover no-repeat fixed;
        }

        .reset-password-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }

        /* Reset Password Card */
        .reset-password-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            margin-right: 0;
        }

        .modern-reset-password-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #000000;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            padding: 30px 35px;
        }

        .reset-password-title {
            text-align: center;
            margin-bottom: 10px;
        }

        .reset-password-title h4 {
            color: #7162ed;
            font-size: 24px;
            font-weight: 600;
            font-family: 'Lilita One', cursive;
            letter-spacing: 1px;
        }

        .reset-password-description {
            text-align: center;
            margin-bottom: 25px;
        }

        .reset-password-description p {
            color: #666666;
            font-size: 11px;
            font-family: 'Poppins', sans-serif;
            line-height: 1.5;
        }

        .modern-form-group {
            margin-bottom: 18px;
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

        .password-wrapper .toggle-password,
        .password-wrapper .toggle-password-confirm {
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
        .password-wrapper .modern-form-control:not(:placeholder-shown) ~ .toggle-password,
        .password-wrapper:hover .toggle-password-confirm,
        .password-wrapper .modern-form-control:focus ~ .toggle-password-confirm,
        .password-wrapper .modern-form-control:not(:placeholder-shown) ~ .toggle-password-confirm {
            display: block;
        }

        .modern-btn-submit {
            background: #7162ed;
            border: none;
            border-radius: 5px;
            padding: 10px 28px;
            font-weight: 400;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 100%;
            height: 42px;
            color: #ffffff;
            font-family: 'Lilita One', cursive;
            letter-spacing: 2px;
            cursor: pointer;
            display: block;
            margin: 0 auto 16px;
        }

        .modern-btn-submit:hover {
            background: #5f4fd4;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(113, 98, 237, 0.4);
        }

        .back-to-login {
            text-align: center;
            margin-top: 16px;
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

        .error-message {
            color: #dc3545;
            font-size: 10px;
            margin-top: 4px;
            display: block;
        }

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            font-size: 11px;
            padding: 10px 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }

        @media (max-width: 1024px) {
            .reset-password-wrapper {
                padding: 0 40px 30px 30px;
            }

            .reset-password-content {
                max-width: 400px;
            }
        }

        @media (max-width: 768px) {
            .reset-password-wrapper {
                justify-content: center;
                padding: 0;
            }

            .reset-password-content {
                margin-right: 0;
                max-width: 100%;
            }

            .modern-reset-password-card {
                padding: 25px 28px;
            }
        }

        @media (max-width: 480px) {
            .modern-reset-password-card {
                padding: 20px 22px;
            }

            .modern-btn-submit {
                font-size: 14px;
                height: 38px;
            }

            .reset-password-title h4 {
                font-size: 20px;
            }
        }
    </style>
@endpush

@section('main')
    <div class="reset-password-wrapper">
        <div class="reset-password-content">
            <div class="modern-reset-password-card">
                <div class="reset-password-title">
                    <h4>Reset Password</h4>
                </div>
                
                <div class="reset-password-description">
                    <p>Masukkan email dan password baru Anda.</p>
                </div>

                @if (session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    
                    <div class="modern-form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <input 
                                id="email"
                                type="email"
                                value="{{ old('email', $request->email) }}"
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
                        <label for="password">Password Baru</label>
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

                    <div class="modern-form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <div class="input-wrapper password-wrapper">
                            <input
                                id="password_confirmation"
                                type="password"
                                class="form-control modern-form-control"
                                name="password_confirmation"
                                tabindex="3"
                                placeholder=" "
                                required>
                            <button type="button" class="toggle-password-confirm">
                                <i class="far fa-eye" id="togglePasswordConfirm"></i>
                            </button>
                        </div>
                        @if($errors->has('password_confirmation'))
                            <span class="error-message">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    <button 
                        type="submit"
                        class="modern-btn-submit"
                        tabindex="4">
                        Reset Password
                    </button>

                    <div class="back-to-login">
                        <a href="{{ route('login') }}" class="modern-link">Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script>
        // Toggle password visibility for password field
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

        if (password) {
            password.addEventListener('input', function() {
                if (this.value.length > 0) {
                    toggleButton.style.display = 'block';
                } else {
                    toggleButton.style.display = 'none';
                }
            });
        }

        // Toggle password visibility for confirmation field
        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
        const toggleButtonConfirm = document.querySelector('.toggle-password-confirm');
        const passwordConfirm = document.querySelector('#password_confirmation');

        if (toggleButtonConfirm && passwordConfirm) {
            toggleButtonConfirm.addEventListener('click', function(e) {
                e.preventDefault();
                const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirm.setAttribute('type', type);
                togglePasswordConfirm.classList.toggle('fa-eye');
                togglePasswordConfirm.classList.toggle('fa-eye-slash');
            });
        }

        if (passwordConfirm) {
            passwordConfirm.addEventListener('input', function() {
                if (this.value.length > 0) {
                    toggleButtonConfirm.style.display = 'block';
                } else {
                    toggleButtonConfirm.style.display = 'none';
                }
            });
        }
    </script>
@endpush
