@extends("layouts.layout")

@section("content")

<!-- 1. Contenedor Imagen Principal -->
<section class="contenedor-imagenPrincipal">
    <div class="imagen-principal-wrapper">
        <img
            src="{{ asset('images/fondos/fondo-orfebreria.png') }}"
            alt="Orfebrería - Imagen principal"
            class="imagen-principal"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
        >
        <div class="imagen-principal-placeholder" style="display: none;">
            <i class="bi bi-gem icono-placeholder"></i>
        </div>
        <div class="imagen-principal-overlay">
            <h1 class="titulo-orfebreria">Orfebrería</h1>
            <p class="subtitulo-orfebreria">Arte y tradición en cada pieza</p>
        </div>
    </div>
</section>

<!-- 2. Contenedor Informativo -->
<section class="contenedor-Informativo">
    <div class="informativo-grid">
        <div class="informativo-imagen">
            <img
                src="{{ asset('images/img-informativas/orfebreria.jpg') }}"
                alt="Proceso de orfebrería"
                class="img-informativa"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="informativo-imagen-placeholder" style="display: none;">
                <i class="bi bi-gem icono-placeholder"></i>
            </div>
        </div>
        <div class="informativo-texto">
            <h2 class="informativo-titulo">Nuestra Orfebrería</h2>
            <p class="informativo-parrafo">
                En nuestro taller combinamos técnicas centenarias con diseños contemporáneos
                para crear piezas únicas que perduran en el tiempo. Cada joya es el resultado
                de un meticuloso proceso artesanal donde la pasión y la precisión se funden
                en oro, plata y piedras preciosas.
            </p>
            <p class="informativo-parrafo">
                Desde anillos de compromiso hasta collares exclusivos, para materializar tus sueños en piezas
                irrepetibles.
            </p>
        </div>
    </div>
</section>

<!-- 3. Contenedor Productos Orfebres -->
<section class="contenedor-productos-orfebres">
    <h2 class="productos-orfebres-titulo">Nuestras Creaciones</h2>
    <div class="productos-orfebres-marco">
        <div class="orfebre-imagen orfebre-imagen-1">
            <img
                src="{{ asset('images/joyas/collar.avif') }}"
                alt="Collar artesanal"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="orfebre-imagen-placeholder" style="display: none;">
                <i class="bi bi-gem icono-placeholder"></i>
            </div>
        </div>
        <div class="orfebre-imagen orfebre-imagen-2">
            <img
                src="{{ asset('images/joyas/carrusel-anillos.png') }}"
                alt="Anillos exclusivos"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="orfebre-imagen-placeholder" style="display: none;">
                <i class="bi bi-gem icono-placeholder"></i>
            </div>
        </div>
        <div class="orfebre-imagen orfebre-imagen-3">
            <img
                src="{{ asset('images/joyas/carrusel-pendientes.png') }}"
                alt="Pendientes de autor"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="orfebre-imagen-placeholder" style="display: none;">
                <i class="bi bi-gem icono-placeholder"></i>
            </div>
        </div>
        <div class="orfebre-imagen orfebre-imagen-4">
            <img
                src="{{ asset('images/joyas/carrusel-pulseras.jpg') }}"
                alt="Pulseras artesanales"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="orfebre-imagen-placeholder" style="display: none;">
                <i class="bi bi-gem icono-placeholder"></i>
            </div>
        </div>
        <div class="orfebre-imagen orfebre-imagen-5">
            <img
                src="{{ asset('images/joyas/exclusiva.webp') }}"
                alt="Pieza exclusiva"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="orfebre-imagen-placeholder" style="display: none;">
                <i class="bi bi-gem icono-placeholder"></i>
            </div>
        </div>
    </div>
</section>

<!-- 4. Contenedor Reservar Cita -->
<section class="contenedor-ReservarCita">
    <div class="reservar-cita-wrapper">
        <h2 class="reservar-cita-titulo">Reservar Cita</h2>
        <p class="reservar-cita-subtitulo">Solicita una cita con nuestros expertos en orfebrería</p>

        <form id="form-reservar-cita" class="form-reservar-cita" method="POST" action="">
            @csrf

            <div class="div-proposito">
                <fieldset class="grupo-proposito">
                    <legend>¿Cuál es el propósito de su cita?</legend>
                    <div class="opciones-radio">
                        <label class="radio-label">
                            <input type="radio" name="proposito" value="productos" checked>
                            <span>Productos</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="proposito" value="servicios">
                            <span>Servicios</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="proposito" value="otro">
                            <span>Otro</span>
                        </label>
                    </div>
                </fieldset>

                <div class="grupo-motivo">
                    <label for="motivo-cita" class="form-label">Motivo de su cita:</label>
                    <select id="motivo-cita" name="motivo" class="form-select">
                        <option value="joyeria">Joyería</option>
                        <option value="encargo">Encargo</option>
                        <option value="diseno-propio">Diseño propio</option>
                    </select>
                </div>
            </div>

            <div class="div-detalles-cita">
                <div class="grupo-fecha">
                    <label for="fecha-cita" class="form-label">Fecha</label>
                    <input type="date" id="fecha-cita" name="fecha" class="form-control" required>
                </div>
                <div class="grupo-hora">
                    <label for="hora-cita" class="form-label">Hora</label>
                    <input type="time" id="hora-cita" name="hora" class="form-control" required>
                </div>
            </div>

            <div class="div-comentarios">
                <label for="comentarios-cita" class="form-label">Comentarios adicionales</label>
                <textarea
                    id="comentarios-cita"
                    name="comentarios"
                    class="form-control"
                    rows="4"
                    placeholder="Cuéntanos más sobre lo que necesitas..."
                ></textarea>
            </div>

            <button type="submit" class="btn-confirmar-cita">
                Confirmar cita
            </button>
        </form>

        <div id="mensaje-confirmacion" class="mensaje-confirmacion" style="display: none;">
            <i class="bi bi-check-circle-fill"></i>
            <p>Se ha enviado y confirmado su cita.</p>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/pages/orfebreria.js') }}"></script>
@endpush
