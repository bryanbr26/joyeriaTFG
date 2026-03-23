<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joyas Pérez - @yield('title', 'Lujo y Elegancia')</title>

    <!-- Bootstrap CSS (compilado desde app.scss) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap js -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Bootstrap Icons (ya incluidos en app.css) -->
    <!-- estilos css personalizados -->
    <!--fuente italiana desde google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
</head>

<body>
    @include("layouts.header")

    <main class="py-4">
        @yield("content")
    </main>

    @include("layouts.footer")




</body>

</html>