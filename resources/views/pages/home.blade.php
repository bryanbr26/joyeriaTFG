@extends('layouts.layout')

@section('hero')
    <div class="hero-section">
        <div class="hero-content">
            <div class="contenedor-titulos">
                <div class="titulo">
                    <h1>Joyas Pérez</h1>
                </div>
                <div class="cont-btn">
                    <button>Descubre la colección</button>

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
            <h1>Joyería con historia y detalle</h1>
            <p>Seleccionamos piezas elegantes para acompañar momentos especiales: anillos, collares, pulseras y pendientes
                pensados para regalar, celebrar y recordar.</p>
            <div class="contenedor-btn-text">
                <button>Ver novedades</button>
            </div>
        </div>
    </section>
    <section class="section-dos">
        <div class="contenedor-text">
            <p>
                En Joyas Pérez cuidamos cada detalle, desde la elección de materiales hasta la presentación final.
                Trabajamos con diseños clásicos y actuales para que encuentres una joya que encaje con tu estilo,
                tu historia y la ocasión que quieres celebrar.
            </p>
        </div>
        <div class="contenedor-animacion">
            <img src="{{ asset('images/joyas/animacion-anillos.png') }}" alt="">
        </div>
    </section>
    <section class="section-tres">
        <div class="contenedor-coleccion-uno">
            <img src="{{ asset('images/joyas/fondo-coleccion-uno.png') }}" alt="">
            <h3>Colección elegante</h3>
            <button>Descúbrelo</button>
        </div>
        <div class="contenedor-coleccion-dos">
            <img src="{{ asset('images/joyas/fondo-coleccion-dos.png') }}" alt="">
            <h3>Detalles para regalar</h3>
            <button>Descúbrelo</button>
        </div>
    </section>
    <section class="section-cuatro">
        <div class="carrusel-joyas">
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-anillos.png') }}" alt="">
                <h3>Anillos</h3>
                <button>Descúbrelo</button>
            </div>
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-pendientes.png') }}" alt="">
                <h3>Pendientes</h3>
                <button>Descúbrelo</button>
            </div>
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-collares.png') }}" alt="">
                <h3>Collares</h3>
                <button>Descúbrelo</button>
            </div>
            <div class="tarjeta">
                <img src="{{ asset('images/joyas/carrusel-pulseras.jpg') }}" alt="">
                <h3>Pulseras</h3>
                <button>Descúbrelo</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const carrusel = document.querySelector('.carrusel-joyas');
            if (!carrusel) return;

            const originalChildren = Array.from(carrusel.children);

            // Duplicar elementos para el efecto de scroll infinito
            originalChildren.forEach(child => {
                const clone = child.cloneNode(true);
                carrusel.appendChild(clone);
            });

            let isDown = false;
            let startX;
            let scrollLeft;
            let autoScrollInterval;
            const speed = 0.6; // Velocidad del auto scroll

            function startAutoScroll() {
                autoScrollInterval = requestAnimationFrame(autoScroll);
            }

            function stopAutoScroll() {
                cancelAnimationFrame(autoScrollInterval);
            }

            function checkBoundary() {
                const firstCard = originalChildren[0];
                const gap = parseFloat(getComputedStyle(carrusel).gap) || 0;
                // Ancho total del set original de tarjetas (incluyendo su gap correspondiente)
                const originalWidth = (firstCard.offsetWidth + gap) * originalChildren.length;

                if (carrusel.scrollLeft >= originalWidth) {
                    // Si se hace scroll más allá del primer set, se reinicia al principio sin salto visual
                    carrusel.scrollLeft -= originalWidth;
                } else if (carrusel.scrollLeft <= 0) {
                    // Si se hace scroll hacia atrás más allá de 0, salta al set clonado
                    carrusel.scrollLeft += originalWidth;
                }
            }

            function autoScroll() {
                if (!isDown) {
                    carrusel.scrollLeft += speed;
                    checkBoundary();
                }
                autoScrollInterval = requestAnimationFrame(autoScroll);
            }

            // Eventos del ratón para arrastrar
            carrusel.addEventListener('mousedown', (e) => {
                isDown = true;
                carrusel.classList.add('dragging');
                startX = e.pageX - carrusel.offsetLeft;
                scrollLeft = carrusel.scrollLeft;
                stopAutoScroll();
            });

            carrusel.addEventListener('mouseleave', () => {
                if (isDown) {
                    isDown = false;
                    carrusel.classList.remove('dragging');
                    startAutoScroll();
                }
            });

            carrusel.addEventListener('mouseup', () => {
                isDown = false;
                carrusel.classList.remove('dragging');
                startAutoScroll();
            });

            carrusel.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - carrusel.offsetLeft;
                const walk = (x - startX) * 1.5; // Multiplicador de velocidad de arrastre
                carrusel.scrollLeft = scrollLeft - walk;
                checkBoundary();
            });

            // Eventos táctiles para móviles
            carrusel.addEventListener('touchstart', (e) => {
                isDown = true;
                startX = e.touches[0].pageX - carrusel.offsetLeft;
                scrollLeft = carrusel.scrollLeft;
                stopAutoScroll();
            });

            carrusel.addEventListener('touchend', () => {
                isDown = false;
                startAutoScroll();
            });

            carrusel.addEventListener('touchmove', (e) => {
                if (!isDown) return;
                const x = e.touches[0].pageX - carrusel.offsetLeft;
                const walk = (x - startX) * 2;
                carrusel.scrollLeft = scrollLeft - walk;
                checkBoundary();
            });

            // Iniciar scroll automático
            startAutoScroll();
        });
    </script>
@endsection
