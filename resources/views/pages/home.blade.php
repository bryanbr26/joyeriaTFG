@extends('layouts.layout')

@section('hero')
    <div class="hero-section">
        <div class="hero-content">
            <div class="contenedor-titulos">
                <div class="titulo">
                    <h1>What is lorem ipsum?</h1>
                </div>
                <div class="cont-btn">
                    <button>Lorem Impsum</button>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section-uno">
        <div class="contenedor-img">
            <img src="{{ asset('images/joyas/banner-1.png') }}" alt="img">
        </div>
        <div class="contenedor-titulos">
            <h1>What is lorem ipsum?</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vulputate leo neque, in dapibus lorem
                porttitor ut. Phasellus a tellus congue, porta ante eu, sodales purus. </p>
            <div class="contenedor-btn-text">
                <button>Lorem Impsum</button>
            </div>
        </div>
    </section>
    <section class="section-dos">
        <div class="contenedor-text">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vulputate leo neque, in dapibus lorem
                porttitor ut. Phasellus a tellus congue, porta ante eu, sodales purus. Praesent eleifend eleifend arcu
                consequat fermentum. Nullam ornare ornare leo, vitae facilisis lacus lobortis sagittis. Phasellus
                sollicitudin magna nisl. In accumsan odio vitae lectus commodo, ut pretium massa pellentesque. Etiam sed
                ullamcorper enim. Nullam cursus mollis lorem, id mollis diam vestibulum
            </p>
        </div>
        <div class="contenedor-animacion">
            <img src="{{ asset('images/joyas/animacion-anillos.png') }}" alt="">
        </div>
    </section>
    <section class="section-tres">
        <div class="contenedor-coleccion-uno">
            <img src="{{ asset('images/joyas/fondo-coleccion-uno.png') }}" alt="">
            <h3>Coleccion 1</h3>
            <button>Descrubelo</button>
        </div>
        <div class="contenedor-coleccion-dos">
            <img src="{{ asset('images/joyas/fondo-coleccion-dos.png') }}" alt="">
            <h3>Coleccion 2</h3>
            <button>Descrubelo</button>
        </div>
    </section>
    <section class="section-cuatro">
        <div class="carrusel-joyas">
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-anillos.png') }}" alt="">
                <h3>Anillos</h3>
                <button>Descrubelo</button>
            </div>
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-pendientes.png') }}" alt="">
                <h3>Pendientes</h3>
                <button>Descrubelo</button>
            </div>
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-collares.png') }}" alt="">
                <h3>Collares</h3>
                <button>Descrubelo</button>
            </div>
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-pulseras.jpg') }}" alt="">
                <h3>Pulseras</h3>
                <button>Descrubelo</button>
            </div>
        </div>
    </section>
    <section class="section-cinco">
        <div class="contenedor-iconos-informativos">
            <div class="targeta-icono">
                <i class="bi bi-box-seam-fill"></i>
                <div class="texto">
                    <h4>Devolucion gratuita en 15 dias</h4>
                </div>
            </div>
            <div class="targeta-icono">
                <i class="bi bi-truck"></i>
                <div class="texto">
                    <h4>Envio gratis a partir de 40€</h4>

                </div>
            </div>
            <div class="targeta-icono">
                <i class="bi bi-gift-fill"></i>
                <div class="texto">
                    <h4>Cajas regalo disponibles</h4>

                </div>
            </div>
            <div class="targeta-icono">
                <i class="bi bi-calendar-check"></i>
                <div class="texto">
                    <h4>Reserva tu cita con nosotros</h4>

                </div>
            </div>
        </div>
    </section>

@endsection