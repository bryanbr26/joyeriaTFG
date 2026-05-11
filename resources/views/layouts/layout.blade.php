<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Joyas Pérez </title>

    <!-- Bootstrap CSS (compilado desde app.scss) -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap js -->
    <script src="{{ mix('js/app.js') }}"></script>

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

</head>

<body class="{{ Route::is('index') ? 'home-page' : '' }}">

    @if(Route::is('index'))
        <div class="hero-wrapper">
            <div class="video-background">
                <video autoplay muted loop playsinline>
                    <source src="{{ asset('images/videos/video-banner.mp4') }}" type="video/mp4">
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
    @stack('scripts')
</body>

</html>