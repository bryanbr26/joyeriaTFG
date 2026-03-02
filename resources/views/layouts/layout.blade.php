<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joyas Pérez - @yield('title', 'Lujo y Elegancia')</title>

    <!-- Bootstrap CSS (compilado) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Estilos globales + tema azul -->
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body>
    @include("layouts.header")

    <main class="site-main py-4">
        @yield("content")
    </main>

    @include("layouts.footer")

    <!-- Scroll Reveal: activa la clase .reveal al hacer scroll -->
    <script>
        (function () {
            const revealEls = document.querySelectorAll('.reveal');
            if (!revealEls.length) return;

            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            revealEls.forEach(function (el) { observer.observe(el); });
        })();
    </script>
</body>

</html>