@extends('layouts.layout')

@section('title', 'Joyas Pérez - Joyería Artesanal')

@section('content')
<!-- Hero Section (hereda el video del layout) -->
<section class="home-hero-section">
    <div class="hero-content text-center text-white">
        <h1 class="display-3 fw-bold mb-4 animate-fade-in">
            Joyas que Cuentan Historias
        </h1>
        <p class="lead mb-4 animate-fade-in-delay">
            Descubre nuestra colección de joyería artesanal única
        </p>

    </div>

    <!-- Scroll indicator -->
    <div class="scroll-down-indicator">
        <span>Descubre más</span>
        <i class="bi bi-chevron-down"></i>
    </div>
</section>

<!-- Secciones del Home -->
<section class="categories-section bg-white">
    <div class="container py-5">
        <h2 class="text-center mb-5">Nuestras Categorías</h2>
        <!-- Tu contenido de categorías -->
    </div>
</section>

<!-- Más secciones... -->
@endsection