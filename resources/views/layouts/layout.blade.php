<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Joyas Pérez </title>

    <!-- Precarga del logo para el loader -->
    <link rel="preload" href="{{ asset('images/logo.svg') }}" as="image">

    <!-- CSS crítico inline: loader -->
    <style>
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: #ffffff;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.7s ease-out, visibility 0.7s ease-out;
        }

        #page-loader.loader-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .loader-logo {
            width: 150px;
            height: auto;
            animation: loaderPulse 2s ease-in-out infinite;
        }

        @media (max-width: 576px) {
            .loader-logo {
                width: 110px;
            }
        }

        .loader-spinner {
            width: 36px;
            height: 36px;
            margin-top: 24px;
            border: 3px solid rgba(0, 0, 0, 0.08);
            border-top-color: #c9a96e;
            border-radius: 50%;
            animation: loaderSpin 1s linear infinite;
        }

        @keyframes loaderPulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        @keyframes loaderSpin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Noscript: ocultar loader inmediatamente */
        noscript #page-loader {
            display: none !important;
        }
    </style>

    <!-- Bootstrap CSS (compilado desde app.scss) -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap Icons (ya incluidos en app.css) -->
    <!-- estilos css personalizados -->
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <!--fuente italiana desde google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&family=Italiana&family=JetBrains+Mono:ital,wght@1,500&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Magra:wght@400;700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&family=Italiana&family=JetBrains+Mono:ital,wght@1,500&family=Kaisei+Opti&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Magra:wght@400;700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    @stack('styles')
</head>

<body class="{{ Route::is('index') ? 'home-page' : '' }}">

    <!-- Page Loader -->
    <div id="page-loader" aria-hidden="true">
        <img src="{{ asset('images/logo.svg') }}" alt="Joyas Pérez" class="loader-logo" aria-hidden="true">
        <div class="loader-spinner" aria-hidden="true"></div>
    </div>

    <noscript>
        <style>#page-loader { display: none !important; }</style>
    </noscript>

    @if(Route::is('index'))
        <div class="hero-wrapper">
            <div class="video-background">
                <video autoplay muted loop playsinline preload="metadata" poster="{{ asset('images/joyas/banner-1.png') }}" id="hero-video">
                    <source src="{{ asset('images/videos/video-fondo-home.mp4') }}" type="video/mp4">
                </video>
                <div class="video-overlay"></div>
            </div>

            @include("layouts.Header")

            @yield("hero")
        </div>

        <main class="main-content pb-4" style="padding-top: 0;">
            @yield("content")
        </main>
    @else
        @include("layouts.Header")

        <main class="main-content pb-4">
            @yield("content")
        </main>
    @endif

    @include("layouts.Footer")

    <!-- Scripts globales -->
    <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

    @stack('scripts')
</body>

</html>
