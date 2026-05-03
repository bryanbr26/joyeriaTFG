@extends('layouts.layout')

@section('title', 'Inicio - Joyas Pérez')

@section('content')
    <div class="home-page">

        <!-- Hero Section de prueba -->
        <section class="hero-section">
            <div class="container">
                <h1>¡Bienvenido a Joyas Pérez!</h1>
                <p class="mt-3">Este es un texto de prueba para verificar los estilos SCSS</p>
                <button class="mt-4">Botón de Prueba</button>
            </div>
        </section>

        <!-- Sección de tarjetas de prueba -->
        <section class="test-cards">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <h3>Tarjeta 1</h3>
                            <p>Este es un texto de prueba para la tarjeta 1</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <h3>Tarjeta 2</h3>
                            <p>Este es un texto de prueba para la tarjeta 2</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <h3>Tarjeta 3</h3>
                            <p>Este es un texto de prueba para la tarjeta 3</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Elemento de prueba adicional -->
        <div class="container text-center my-5">
            <div class="test-bg">
                <p>Si ves esto con fondo rojo, ¡los estilos están funcionando!</p>
            </div>
        </div>

    </div>
@endsection