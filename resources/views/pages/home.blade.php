{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.layout')

@section('content')
    <!-- Hero section con video continuo -->
    <section class="hero-section" id="homeHero">
        <div class="hero-content">
            <h1 class="hero-title">Bienvenido a Joyas Pérez</h1>
            <p class="hero-subtitle">Descubre la elegancia en cada pieza</p>
            <div class="hero-buttons">
                <a href="{{ route('joyas.index', 'collares') }}" class="btn btn-gold">Ver Colección</a>
                <a href="{{ route('personaliza') }}" class="btn btn-outline-light">Personalizar</a>
            </div>
        </div>
    </section>

    {{-- Resto del contenido de la página --}}
    <section class="container my-5">
        <!-- Tu contenido adicional -->
    </section>
@endsection

@section('scripts')
    @parent
    <script>
        // Opcional: Ajustar altura del hero según el header
        document.addEventListener('DOMContentLoaded', function () {
            const header = document.getElementById('mainHeader');
            const hero = document.getElementById('homeHero');
            if (header && hero) {
                const headerHeight = header.offsetHeight;
                hero.style.height = `calc(100vh - ${headerHeight}px)`;
            }
        });
    </script>
@endsection