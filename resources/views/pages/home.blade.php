@extends('layouts.layout')

@section('hero')
    <div class="hero-section">
        <div class="hero-content">
            <div class="contenedor-titulos">
                <div class="titulo">
                    <h1>Joyería Perez</h1>
                </div>
                <div class="cont-btn">
                    <a href="{{ route('joyas.index', 'anillos') }}" class="btn-hero">Descubre más</a>

                </div>
            </div>
        </div>
    </div>
@push('scripts')
    <script src="{{ mix('js/pages/home.js') }}" defer></script>
@endpush

@endsection

@section('content')
    <section class="section-uno animar-seccion-izquierda">
        <div class="contenedor-img animar-entrada-izquierda">
            <img src="{{ asset('images/joyas/banner-1.png') }}" alt="Colección exclusiva de joyas artesanales" loading="lazy" decoding="async">
        </div>
        <div class="contenedor-titulos">
            <h1>Arte y elegancia en cada pieza</h1>
            <p>En Joyas Perez transformamos metales preciosos y gemas exclusivas en joyas únicas que cuentan historias. Cada diseño refleja décadas de tradición orfebre y una pasión inquebrantable por la excelencia. Descubre piezas que perduran para siempre.</p>
            <div class="contenedor-btn-text">
                <a href="{{ route('joyas.index', 'anillos') }}" class="btn-seccion">Ver colección</a>
            </div>
        </div>
    </section>
    
    <section class="section-dos animar-seccion-derecha">
        <div class="contenedor-text">
            <p>
                Joyas Perez ha sido sinónimo de calidad y distinción. Combinamos técnicas tradicionales con diseños vanguardistas para crear piezas que enamoran a primera vista. Cada anillo, collar y pulsera es elaborado a mano con los más altos estándares de calidad, utilizando oro de 18 quilates, plata esterlina y gemas cuidadosamente seleccionadas. Te invitamos a descubrir una experiencia única donde el lujo y la artesanía se fusionan en perfecta armonía.
            </p>
        </div>
        <div class="contenedor-animacion animar-entrada-derecha">
            <img src="{{ asset('images/joyas/animacion-anillos.png') }}" alt="Anillos de oro y plata artesanales" loading="lazy" decoding="async">
        </div>
    </section>
    <section class="section-tres">
        <div class="contenedor-coleccion-uno animar-entrada-arriba">
            <img src="{{ asset('images/joyas/fondo-coleccion-uno.png') }}" alt="Colección de collares elegantes" loading="lazy" decoding="async">
            <h3>Colección 1</h3>
            <a href="{{ route('joyas.index', 'collares') }}" class="btn-coleccion">Descúbrelo</a>
             
        </div>
        <div class="contenedor-coleccion-dos animar-entrada-arriba-retrasada">
            <img src="{{ asset('images/joyas/fondo-coleccion-dos.png') }}" alt="Colección de pulseras exclusivas" loading="lazy" decoding="async">
            <h3>Colección 2</h3>
            <a href="{{ route('joyas.index', 'pulseras') }}" class="btn-coleccion">Descúbrelo</a>
        </div>
    </section>
    <section class="section-cuatro">
        <div class="carrusel-joyas">
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-anillos.png') }}" alt="Anillos exclusivos" loading="lazy" decoding="async">
                <h3>Anillos</h3>
                <a href="{{ route('joyas.index', 'anillos') }}" class="btn-carrusel">Descúbrelo</a>
            </div>
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-pendientes.png') }}" alt="Pendientes elegantes" loading="lazy" decoding="async">
                <h3>Pendientes</h3>
                <a href="{{ route('joyas.index', 'pendientes') }}" class="btn-carrusel">Descúbrelo</a>
            </div>
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-collares.png') }}" alt="Collares refinados" loading="lazy" decoding="async">
                <h3>Collares</h3>
                <a href="{{ route('joyas.index', 'collares') }}" class="btn-carrusel">Descúbrelo</a>
            </div>
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-pulseras.jpg') }}" alt="Pulseras artesanales" loading="lazy" decoding="async">
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
