@extends("layouts.layout")

@section("content")

<!-- ============================================
     1. HERO DE CONTACTO — Panel informativo
     ============================================ -->
<section class="contact-hero">
    <div class="contact-hero__bg" aria-hidden="true"></div>

    <div class="contact-hero__panel">
        <h1>Contacto</h1>
        <p class="contact-subtitle">Nuestra Maison</p>

        <div class="contact-info">
            <div class="info-item">
                <i class="bi bi-geo-alt"></i>
                <span>Calle Mayor, 24 — 28013 Madrid</span>
            </div>
            <div class="info-item">
                <i class="bi bi-telephone"></i>
                <span>+34 91 123 45 67</span>
            </div>
            <div class="info-item">
                <i class="bi bi-envelope"></i>
                <span>contacto@joyasperez.com</span>
            </div>
            <div class="info-item">
                <i class="bi bi-clock"></i>
                <span>Lunes a Viernes — 10:00 a 20:00 h</span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     2. ATELIER — Formulario de contacto
     ============================================ -->
<section class="contact-atelier">
    <div class="container">
        <div class="row g-0">

            <!-- Bloque decorativo / mensaje -->
            <div class="col-lg-5 contact-atelier__image" id="contact-atelier-image">
                <div class="atelier-block">
                    <h2>Atención<br>Personalizada</h2>
                    <p>Cada pieza cuenta una historia única. Permítanos ser parte de la suya y descubra el arte de la joyería hecha a medida.</p>
                    <div class="atelier-signature">— Joyas Pérez</div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="col-lg-7 contact-atelier__form">
                <div class="form-header">
                    <h3>Escríbanos</h3>
                    <p>Complete el siguiente formulario y nuestro equipo le atenderá con la mayor discreción.</p>
                </div>

                <form action="{{ route('contacto.enviar') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-luxury">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="luxury-input" id="nombre" name="nombre" placeholder="Su nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-luxury">
                                <label for="email">Email</label>
                                <input type="email" class="luxury-input" id="email" name="email" placeholder="Su correo electrónico" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-luxury">
                        <label for="asunto">Asunto</label>
                        <select class="luxury-select" id="asunto" name="asunto" required>
                            <option value="" disabled selected>Seleccione un motivo</option>
                            <option value="pedido">Información de pedido</option>
                            <option value="personalizacion">Personalización</option>
                            <option value="cita">Solicitar cita</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="form-group-luxury">
                        <label for="mensaje">Mensaje</label>
                        <textarea class="luxury-textarea" id="mensaje" name="mensaje" rows="4" placeholder="¿En qué podemos ayudarle?" required></textarea>
                    </div>

                    <button type="submit" class="btn-luxury-submit">
                        Enviar mensaje
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection
