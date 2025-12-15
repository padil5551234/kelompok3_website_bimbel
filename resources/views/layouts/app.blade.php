<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags -->
        <meta name="description" content="Platform Bimbel Kedinasan STIS terbaik untuk persiapan ujian kedinasan STIS. Ribuan soal latihan SKD STIS, simulasi ujian real-time, pembahasan lengkap, dan materi belajar berkualitas tinggi khusus kedinasan STIS.">
        <meta name="keywords" content="bimbel kedinasan STIS, tryout kedinasan STIS, SKD STIS, ujian kedinasan STIS, persiapan STIS, materi belajar kedinasan STIS, simulasi ujian STIS, soal latihan STIS">
        <meta name="author" content="{{ config('app.name', 'Laravel') }}">
        <meta name="robots" content="index, follow">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ config('app.name', 'Laravel') }} - Platform Bimbel Kedinasan STIS Terbaik">
        <meta property="og:description" content="Platform Bimbel Kedinasan STIS terbaik untuk persiapan ujian kedinasan STIS. Ribuan soal latihan SKD STIS dan simulasi ujian berkualitas khusus kedinasan STIS.">
        <meta property="og:image" content="{{ asset('img/logo.png') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ config('app.name', 'Laravel') }} - Platform Bimbel Kedinasan STIS Terbaik">
        <meta property="twitter:description" content="Platform Bimbel Kedinasan STIS terbaik untuk persiapan ujian kedinasan STIS. Ribuan soal latihan SKD STIS dan simulasi ujian berkualitas khusus kedinasan STIS.">
        <meta property="twitter:image" content="{{ asset('img/logo.png') }}">

        <!-- Schema.org JSON-LD -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "EducationalOrganization",
            "name": "{{ config('app.name', 'Laravel') }}",
            "description": "Platform Bimbel Kedinasan STIS terbaik untuk persiapan ujian kedinasan STIS",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('images/logo.png') }}",
            "sameAs": [
                "https://facebook.com/tryoutmaster",
                "https://instagram.com/tryoutmaster_id",
                "https://twitter.com/tryoutmaster",
                "https://www.youtube.com/@tryoutmaster"
            ],
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+62-21-1234-5678",
                "email": "padilzaki73@gmail.com",
                "contactType": "customer service",
                "availableLanguage": ["Indonesian", "English"],
                "hoursAvailable": {
                    "@type": "OpeningHoursSpecification",
                    "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                    "opens": "08:00",
                    "closes": "17:00"
                }
            },
            "offers": {
                "@type": "Offer",
                "category": "Online Course",
                "description": "Akses bimbel kedinasan STIS, tryout SKD STIS, simulasi ujian kedinasan STIS, dan materi pembelajaran berkualitas khusus STIS"
            }
        }
        </script>

        <title>@yield('title', config('app.name', 'Laravel') . ' - Platform Bimbel Kedinasan STIS Terbaik')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="dns-prefetch" href="//fonts.bunny.net">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
