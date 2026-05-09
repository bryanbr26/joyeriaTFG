@extends('layouts.layout')

@section('hero')
    <div class="hero-section">
        <div class="hero-content">
            <div class="contenedor-titulos">
                <div class="titulo">
                    <h1>What is lorem ipsum?</h1>
                </div>
                <div class="cont-btn">
                    <button type="button">Lorem Impsum</button>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- Resto del contenido de la home --}}

    <div class="container">
        <h2>Nuestros productos</h2>
    </div>
    <div class="section-categorias">
        <h3>Categorias</h3>
    </div>
@endsection