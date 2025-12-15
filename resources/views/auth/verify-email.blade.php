@extends('layouts.auth')

@section('title', 'Konfirmasi Email')

@push('style')
    <!-- CSS Libraries -->
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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

        .verify-email-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 40px;
            background: url('{{ asset('img/login.png') }}') center/cover no-repeat fixed;
        }

        .verify-email-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }

        /* Verify Email Card */
        .verify-email-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            margin-right: 0;
        }

        .modern-verify-email-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #000000;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            padding: 30px 35px;
        }

        .verify-email-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .verify-email-logo img {
            max-width: 120px;
            height: auto;
        }

        .verify-email-title {
            text-align: center;
            margin-bottom: 10px;
        }

        .verify-email-title h4 {
            color: #7162ed;
            font-size: 24px;
            font-weight: 600;
            font-family: 'Lilita One', cursive;
            letter-spacing: 1px;
        }

        .verify-email-description {
            text-align: center;
            margin-bottom: 25px;
        }

        .verify-email-description p {
            color: #666666;
            font-size: 11px;
            font-family: 'Poppins', sans-serif;
            line-height: 1.5;
        }

        .verify-email-btn {
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

        .verify-email-btn:hover {
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

        @media (max-width: 768px) {
            .verify-email-wrapper {
                padding: 20px;
            }

            .verify-email-content {
                max-width: 100%;
            }

            .modern-verify-email-card {
                padding: 25px 28px;
            }
        }

        @media (max-width: 480px) {
            .modern-verify-email-card {
                padding: 20px 22px;
            }

            .verify-email-btn {
                font-size: 14px;
                height: 38px;
            }

            .verify-email-title h4 {
                font-size: 20px;
            }
        }
    </style>
@endpush

@section('main')
    <div class="verify-email-wrapper">
        <div class="verify-email-content">
            <div class="modern-verify-email-card">
                <div class="verify-email-logo">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo">
                </div>

                <div class="verify-email-title">
                    <h4>Konfirmasi Email</h4>
                </div>

                <div class="verify-email-description">
                    <p>Sebelum melanjutkan, bisakah Anda memverifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan melalui email kepada Anda? Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan email lainnya kepada Anda.</p>
                </div>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <button
                        type="submit"
                        class="verify-email-btn"
                        tabindex="4">
                        Kirim Ulang Email
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
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
