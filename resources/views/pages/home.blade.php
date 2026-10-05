@extends('layouts.layout')

@section('hero')
    <div class="hero-section">
        <div class="hero-content">
            <div class="contenedor-home-titulos">
                <div class="titulo">
                    <h1>Las cuentas doradas se combinan con piedras preciosas</h1>
                    <p>Nuestras coleccion de joyas estan diseñada con artesania fina</p>
                    <a href="{{ route('joyas.index', 'anillos') }}">Explora nuestra coleccion</a>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
    <script src="{{ mix('js/pages/home.js') }}" defer></script>
@endpush

@endsection

@section('content')
    <section class="section-uno">
        <div class="contenedor-img animar-entrada-izquierda">
            {{-- Canvas para la animación frame-by-frame controlada por scroll.
                 La configuración (ruta, total de frames, recorrido del pin) va en data-attributes. --}}
            <canvas
                class="frames-canvas"
                role="img"
                aria-label="Animación de una joya artesanal que avanza cuadro a cuadro al hacer scroll"
                data-frames-base="{{ asset('images/frames') }}"
                data-total-frames="119"
                data-pin-end="+=200%"
            ></canvas>
            {{-- Fallback sin JavaScript: primer frame como imagen estática --}}
            <noscript>
                {!! responsive_picture('frames/frame_001.webp', 'Colección exclusiva de joyas artesanales', ['loading' => 'lazy', 'decoding' => 'async']) !!}
            </noscript>
        </div>
        <div class="contenedor-titulos">
            <h1>Arte y elegancia<br>
          
            en cada pieza</h1>
            <p>En Joyas Pérez transformamos metales preciosos y gemas exclusivas en joyas únicas que cuentan historias. Cada diseño refleja décadas de tradición orfebre y una pasión inquebrantable por la excelencia. Descubre piezas que perduran para siempre.</p>
            <div class="contenedor-btn-text">
                <a href="{{ route('joyas.index', 'anillos') }}" class="btn-seccion">Ver colección</a>
            </div>
        </div>
    </section>


    <section class="section-dos animar-seccion-derecha">
            {!! responsive_picture('fondos/caballo-de-soria.png', 'Colección exclusiva de joyas artesanales', ['loading' => 'lazy', 'decoding' => 'async']) !!}
            <div class="contenedor-text">
                <h1>El tiempo galopa pero el recuerdo permanece</h1>
                <p>Enim aliqua ullamco sint ullamco tempor esse aliqua.</p>
                <a href="{{ route('joyas.index', 'colecciones') }}" class="enlace-simple">Ver colección</a>
            </div>
        
    </section>
    <section class="section-tres">
        <div class="contenedor-coleccion-uno animar-entrada-arriba">
            {!! responsive_picture('publicidad-home/banner-uno.png', 'Colección de collares elegantes', ['loading' => 'lazy', 'decoding' => 'async']) !!}
            <h3>COLECCION DE OTOÑO</h3>
            <a href="{{ route('joyas.index', 'collares') }}" class="btn-coleccion">Descubre más</a>
             
        </div>
        <div class="contenedor-coleccion-dos animar-entrada-arriba-retrasada">
            {!! responsive_picture('publicidad-home/banner-dos.png', 'Colección de pulseras exclusivas', ['loading' => 'lazy', 'decoding' => 'async']) !!}
            <h3>COLECCION ORIGENES</h3>
            <a href="{{ route('joyas.index', 'pulseras') }}" class="btn-coleccion">Descubre más</a>
        </div>
    </section>
    <section class="section-cuatro">
        <div class="carrusel-joyas">
            <div class="tarjeta">
                {!! responsive_picture('joyas/carrusel-anillos.png', 'Anillos exclusivos', ['loading' => 'lazy', 'decoding' => 'async']) !!}
                <h3>Anillos</h3>
                <a href="{{ route('joyas.index', 'anillos') }}" class="btn-carrusel">Descúbrelo</a>
            </div>
            <div class="tarjeta">
                {!! responsive_picture('joyas/carrusel-pendientes.png', 'Pendientes elegantes', ['loading' => 'lazy', 'decoding' => 'async']) !!}
                <h3>Pendientes</h3>
                <a href="{{ route('joyas.index', 'pendientes') }}" class="btn-carrusel">Descúbrelo</a>
            </div>
            <div class="tarjeta">
                {!! responsive_picture('joyas/carrusel-collares.png', 'Collares refinados', ['loading' => 'lazy', 'decoding' => 'async']) !!}
                <h3>Collares</h3>
                <a href="{{ route('joyas.index', 'collares') }}" class="btn-carrusel">Descúbrelo</a>
            </div>
            <div class="tarjeta">
                {!! responsive_picture('joyas/carrusel-pulseras.jpg', 'Pulseras artesanales', ['loading' => 'lazy', 'decoding' => 'async']) !!}
                <h3>Pulseras</h3>
                <a href="{{ route('joyas.index', 'pulseras') }}" class="btn-carrusel">Descúbrelo</a>
            </div>
        </div>
    </section>
    <section class="section-cinco">
        <div class="contenedor-iconos-informativos">
            <div class="targeta-icono">
                <i class="bi bi-box-seam-fill"></i>
                <div class="texto">
                    <h4>Devolución gratuita en 15 días</h4>
                </div>
            </div>
            <div class="targeta-icono">
                <i class="bi bi-truck"></i>
                <div class="texto">
                    <h4>Envío gratis a partir de 40€</h4>

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
