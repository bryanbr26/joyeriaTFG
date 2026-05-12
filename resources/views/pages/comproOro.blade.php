@extends("layouts.layout")

@section("content")

{{-- Hero --}}
<section class="compro-hero">
    <div class="compro-hero__content text-center">
        <h1>Compro Oro</h1>
        <p>Valoramos tus joyas de oro, plata y piedras preciosas al mejor precio del mercado.</p>
    </div>
</section>

{{-- Introducción --}}
<section class="compro-intro container text-center">
    <h2>¿Por qué vender tu oro en Joyas Pérez?</h2>
    <p>
        En Joyas Pérez llevamos más de una década tasando y comprando oro en Soria.
        Ofrecemos una valoración transparente y honesta, con precios actualizados según la cotización diaria del oro.
        Sin intermediarios, sin comisiones ocultas.
    </p>
</section>

{{-- Pasos del proceso --}}
<section class="compro-pasos container">
    <h2 class="text-center">¿Cómo funciona?</h2>
    <div class="compro-pasos__grid">
        <div class="compro-paso">
            <div class="compro-paso__numero">1</div>
            <h3>Trae tus joyas</h3>
            <p>Acércate a nuestra tienda con las piezas que desees vender. No es necesario cita previa.</p>
        </div>
        <div class="compro-paso">
            <div class="compro-paso__numero">2</div>
            <h3>Tasación gratuita</h3>
            <p>Nuestro experto evaluará tus piezas en el momento, sin compromiso y de forma totalmente gratuita.</p>
        </div>
        <div class="compro-paso">
            <div class="compro-paso__numero">3</div>
            <h3>Cobro inmediato</h3>
            <p>Si aceptas la oferta, recibirás el pago al instante en efectivo o transferencia bancaria.</p>
        </div>
    </div>
</section>

{{-- Qué compramos --}}
<section class="compro-tipos container text-center">
    <h2>¿Qué compramos?</h2>
    <div class="compro-tipos__grid">
        <div class="compro-tipo">
            <i class="bi bi-gem"></i>
            <h4>Oro</h4>
            <p>Anillos, cadenas, pulseras, pendientes y cualquier pieza de oro.</p>
        </div>
        <div class="compro-tipo">
            <i class="bi bi-diamond"></i>
            <h4>Plata</h4>
            <p>Cubertería, bandejas, joyas y objetos de plata de ley.</p>
        </div>
        <div class="compro-tipo">
            <i class="bi bi-stars"></i>
            <h4>Piedras preciosas</h4>
            <p>Diamantes, rubíes, esmeraldas y zafiros.</p>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="compro-cta text-center">
    <h2>¿Tienes joyas que ya no usas?</h2>
    <p>Ven a visitarnos o contacta con nosotros para más información.</p>
    <a href="{{ route('contacto') }}" class="compro-cta__btn">Contactar</a>
</section>

@endsection