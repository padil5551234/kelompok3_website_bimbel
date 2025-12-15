@extends('layouts.auth')

@section('title', 'Lupa Password')

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
        
        .forgot-password-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: relative;
            padding: 40px 60px 40px 40px;
            background: url('{{ asset('img/login.png') }}') center/cover no-repeat fixed;
        }
        
        .forgot-password-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }
        
        /* Forgot Password Card */
        .forgot-password-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            margin-right: 0;
        }
        
        .modern-forgot-password-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #000000;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            padding: 30px 35px;
        }

        .forgot-password-title {
            text-align: center;
            margin-bottom: 10px;
        }

        .forgot-password-title h4 {
            color: #7162ed;
            font-size: 24px;
            font-weight: 600;
            font-family: 'Lilita One', cursive;
            letter-spacing: 1px;
        }

        .forgot-password-description {
            text-align: center;
            margin-bottom: 25px;
        }

        .forgot-password-description p {
            color: #666666;
            font-size: 11px;
            font-family: 'Poppins', sans-serif;
            line-height: 1.5;
        }
        
        .modern-form-group {
            margin-bottom: 24px;
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
            .forgot-password-wrapper {
                padding: 30px 40px 30px 30px;
            }
            
            .forgot-password-content {
                max-width: 400px;
            }
        }
        
        @media (max-width: 768px) {
            .forgot-password-wrapper {
                justify-content: center;
                padding: 20px;
            }
            
            .forgot-password-content {
                margin-right: 0;
                max-width: 100%;
            }
            
            .modern-forgot-password-card {
                padding: 25px 28px;
            }
        }

        @media (max-width: 480px) {
            .modern-forgot-password-card {
                padding: 20px 22px;
            }

            .modern-btn-submit {
                font-size: 14px;
                height: 38px;
            }

            .forgot-password-title h4 {
                font-size: 20px;
            }
        }
    </style>
@endpush

@section('main')
    <div class="forgot-password-wrapper">
        <div class="forgot-password-content">
            <div class="modern-forgot-password-card">
                <div class="forgot-password-title">
                    <h4>Lupa Password</h4>
                </div>
                
                <div class="forgot-password-description">
                    <p>Link reset password akan dikirim ke email.</p>
                </div>

                @if (session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
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

                    <button 
                        type="submit"
                        class="modern-btn-submit"
                        tabindex="2">
                        Kirim Link Reset
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
@endpush
