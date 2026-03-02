@extends("layouts.layout")

@section("title", "Inicio")

@section("content")

{{-- ════════════════════════════════════════
     HERO — Bienvenida
════════════════════════════════════════ --}}
<section class="home-hero text-center my-5 mx-auto" style="max-width:860px;">
    <i class="bi bi-gem text-primary fs-1 mb-3 d-block anim-fade-in-down"></i>

    @if(auth()->user())
        <h2 class="anim-fade-in-down anim-delay-1">
            Bienvenido de nuevo, {{ auth()->user()->nombre }}
        </h2>
        <p class="anim-fade-in anim-delay-2">
            Explora nuestra colección de joyas artesanales elaboradas con los mejores materiales.
        </p>
        <a href="{{ route('joyas.index', 'collares') }}" class="btn btn-primary anim-fade-in-up anim-delay-3">
            <i class="bi bi-sparkle me-2"></i>Ver colección
        </a>
    @else
        <h2 class="anim-fade-in-down anim-delay-1">Bienvenido a Joyas Pérez</h2>
        <p class="anim-fade-in anim-delay-2">
            Descubre nuestra selección de joyas artesanales. Inicia sesión para una experiencia personalizada.
        </p>
        <div class="d-flex justify-content-center gap-3 anim-fade-in-up anim-delay-3">
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="bi bi-person me-2"></i>Iniciar sesión
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary">
                <i class="bi bi-person-plus me-2"></i>Registrarse
            </a>
        </div>
    @endif
</section>

{{-- ════════════════════════════════════════
     CATEGORÍAS — Tarjetas rápidas
════════════════════════════════════════ --}}
<section class="container mb-5 reveal">
    <div class="row g-4 text-center">
        <div class="col-6 col-md-3">
            <a href="{{ route('joyas.index', 'anillos') }}" class="text-decoration-none">
                <div class="card p-3 h-100">
                    <i class="bi bi-circle fs-2 text-primary mb-2"></i>
                    <h6 class="fw-semibold" style="color:var(--blue-600)">Anillos</h6>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('joyas.index', 'collares') }}" class="text-decoration-none">
                <div class="card p-3 h-100">
                    <i class="bi bi-gem fs-2 text-primary mb-2"></i>
                    <h6 class="fw-semibold" style="color:var(--blue-600)">Collares</h6>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('joyas.index', 'pulseras') }}" class="text-decoration-none">
                <div class="card p-3 h-100">
                    <i class="bi bi-watch fs-2 text-primary mb-2"></i>
                    <h6 class="fw-semibold" style="color:var(--blue-600)">Pulseras</h6>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('joyas.index', 'pendientes') }}" class="text-decoration-none">
                <div class="card p-3 h-100">
                    <i class="bi bi-stars fs-2 text-primary mb-2"></i>
                    <h6 class="fw-semibold" style="color:var(--blue-600)">Pendientes</h6>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     SECCIÓN 1 — Anillos (imagen izquierda)
════════════════════════════════════════ --}}
<section class="container my-5 reveal">
    <div class="row align-items-center g-5">
        <div class="col-12 col-md-6">
            <img src="{{ asset('assets/joya_anillo.png') }}"
                 alt="Anillo de compromiso"
                 class="img-fluid rounded-4 shadow-lg section-img">
        </div>
        <div class="col-12 col-md-6">
            <span class="section-label">Joyería exclusiva</span>
            <h2 class="section-title mt-2">Anillos que cuentan<br>una historia</h2>
            <p class="section-text">
                Desde sencillos aros de oro hasta exquisitos anillos de compromiso con diamantes,
                nuestra colección está diseñada para los momentos más importantes de tu vida.
                Cada pieza es trabajada a mano con metales certificados y piedras de la máxima pureza.
            </p>
            <ul class="section-list">
                <li><i class="bi bi-check-circle-fill me-2"></i>Oro 18 y 24 quilates</li>
                <li><i class="bi bi-check-circle-fill me-2"></i>Diamantes certificados GIA</li>
                <li><i class="bi bi-check-circle-fill me-2"></i>Grabado personalizado gratuito</li>
            </ul>
            <a href="{{ route('joyas.index', 'anillos') }}" class="btn btn-primary mt-3">
                Ver anillos <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     BANNER — Franja decorativa
════════════════════════════════════════ --}}
<section class="section-banner my-5 reveal">
    <div class="container text-center py-5">
        <p class="banner-quote">"La elegancia no es llamar la atención, sino ser recordada."</p>
        <p class="banner-sub">— Giorgio Armani</p>
    </div>
</section>

{{-- ════════════════════════════════════════
     SECCIÓN 2 — Collares (imagen derecha)
════════════════════════════════════════ --}}
<section class="container my-5 reveal">
    <div class="row align-items-center g-5 flex-md-row-reverse">
        <div class="col-12 col-md-6">
            <img src="{{ asset('assets/joya_collar.png') }}"
                 alt="Collar de zafiro"
                 class="img-fluid rounded-4 shadow-lg section-img">
        </div>
        <div class="col-12 col-md-6">
            <span class="section-label">Nueva colección</span>
            <h2 class="section-title mt-2">Collares que<br>iluminan tu presencia</h2>
            <p class="section-text">
                Nuestros collares combinan tradición artesanal y diseño contemporáneo.
                Elige entre cadenas de oro, gargantillas con piedras preciosas o colgantes
                personalizados que te identifiquen. El lujo que llevas siempre contigo.
            </p>
            <ul class="section-list">
                <li><i class="bi bi-check-circle-fill me-2"></i>Zafiros, rubíes y esmeraldas naturales</li>
                <li><i class="bi bi-check-circle-fill me-2"></i>Diseño exclusivo bajo pedido</li>
                <li><i class="bi bi-check-circle-fill me-2"></i>Estuche de regalo incluido</li>
            </ul>
            <a href="{{ route('joyas.index', 'collares') }}" class="btn btn-primary mt-3">
                Ver collares <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     SECCIÓN 3 — Pulseras (imagen izquierda)
════════════════════════════════════════ --}}
<section class="container my-5 reveal">
    <div class="row align-items-center g-5">
        <div class="col-12 col-md-6">
            <img src="{{ asset('assets/joya_pulsera.png') }}"
                 alt="Pulsera de oro con diamantes"
                 class="img-fluid rounded-4 shadow-lg section-img">
        </div>
        <div class="col-12 col-md-6">
            <span class="section-label">Artesanía de lujo</span>
            <h2 class="section-title mt-2">Pulseras hechas<br>para brillar</h2>
            <p class="section-text">
                Desde elegantes esclavas de oro hasta brazaletes con brillantes engastados,
                nuestras pulseras son el complemento perfecto para cualquier ocasión.
                Regala o regálate un toque de sofisticación que nunca pasa de moda.
            </p>
            <ul class="section-list">
                <li><i class="bi bi-check-circle-fill me-2"></i>Modelos para mujer, hombre y niño</li>
                <li><i class="bi bi-check-circle-fill me-2"></i>Acabados en oro blanco, amarillo y rosado</li>
                <li><i class="bi bi-check-circle-fill me-2"></i>Garantía de por vida</li>
            </ul>
            <a href="{{ route('joyas.index', 'pulseras') }}" class="btn btn-primary mt-3">
                Ver pulseras <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     CTA FINAL
════════════════════════════════════════ --}}
<section class="container my-5 reveal">
    <div class="text-center py-5 px-3 rounded-4"
         style="background: linear-gradient(135deg, var(--blue-50), var(--blue-100));">
        <i class="bi bi-envelope-heart fs-2 text-primary mb-3 d-block"></i>
        <h3 style="color:var(--blue-600); font-family:'Cormorant Garamond',serif;">
            ¿Buscas algo especial?
        </h3>
        <p class="text-muted mx-auto" style="max-width:480px;">
            Contacta con nuestros expertos y diseñamos juntos la joya perfecta para ti o para quien más quieres.
        </p>
        <a href="{{ route('contacto') }}" class="btn btn-primary">
            <i class="bi bi-chat-dots me-2"></i>Contactar con un experto
        </a>
    </div>
</section>

@endsection