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
</head>

<body>
    @include("layouts.header")

    <main class="py-4">
        @yield("content")
    </main>

    @include("layouts.footer")




</body>

</html>