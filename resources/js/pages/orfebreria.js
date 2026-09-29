/**
 * Orfebrería Page Scripts
 * Maneja el formulario de reserva de citas y utilidades de la página
 */
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', function () {
    initFormularioCita();
    initLazyLoadingOrfebreria();
    initFechaMinima();
    initGaleriaOrfebreria();
    initRelojOrfebreria();
});

// ==========================================================
// GALERÍA ORFEBRE — pin con ScrollTrigger
// ==========================================================
// PLANTILLA DE DISPOSICIÓN DE CADA IMAGEN
//
// Cada entrada define hacia dónde viaja una imagen mientras la
// galería está pineada. Bajar el scroll la lleva de su posición
// origen (la del SCSS) al punto final; subir revierte el recorrido.
//
//   selector   Clase de la imagen dentro de .galeria-orfebre
//   x          Desplazamiento final en % del ANCHO de la galería
//              (positivo = derecha, negativo = izquierda)
//   y          Desplazamiento final en % del ALTO de la galería
//              (positivo = abajo, negativo = arriba)
//   rotacion   Grados de giro al llegar al punto final (0 = sin giro)
//   escala     Escala al llegar al punto final (1 = sin cambio)
//   xPercent / yPercent
//              Desplazamiento base en % del tamaño de la PROPIA imagen.
//              Se usa para centrar imágenes sin transform en el CSS
//              (p. ej. la imagen central usa -50 / -50).
// ==========================================================
const GALERIA_ORFEBRE_CONFIG = {
    // Cuándo empieza el pin: 'top top' = cuando el borde superior de la
    // galería llega al borde superior del viewport.
    start: 'top top',
    // Distancia de scroll durante la que la galería queda pineada.
    // '+=120%' = 120% del alto del viewport. Al superarla, el scroll continúa.
    end: '+=120%',
    imagenes: [
        { selector: '.colgante-dorado',  x: -10, y: -5, rotacion: 0, escala: 1 },
        { selector: '.anillo-serpiente', x: 0,   y: 0,   rotacion: 0,  escala: 1, xPercent: -50, yPercent: -50 },
        { selector: '.colgante-oro',     x: 10,  y: 0, rotacion: 0,  escala: 1 },
        { selector: '.colgante-rosa',    x: -5, y: 10,  rotacion: 0, escala: 1 },
        { selector: '.collar-azul',      x: 10,  y: 10,  rotacion: 0,  escala: 1 },
    ],
};

/** Gsap animation galeria de imagenes */
function initGaleriaOrfebreria() {
    const galeria = document.getElementById('galeria-orfebre');
    if (!galeria) return;

    const mm = gsap.matchMedia();

    mm.add(
        {
            isDesktop: '(min-width: 992px)',
            reduceMotion: '(prefers-reduced-motion: reduce)',
        },
        (context) => {
            const { isDesktop, reduceMotion } = context.conditions;

            // Móvil o movimiento reducido: sin pin, imágenes en su posición CSS
            if (!isDesktop || reduceMotion) return;

            // Posiciones base que no pueden vivir en el CSS (GSAP controla
            // el transform completo durante la animación)
            GALERIA_ORFEBRE_CONFIG.imagenes.forEach((cfg) => {
                const img = galeria.querySelector(cfg.selector);
                if (!img) return;
                gsap.set(img, {
                    xPercent: cfg.xPercent ?? 0,
                    yPercent: cfg.yPercent ?? 0,
                });
            });

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: galeria,
                    start: GALERIA_ORFEBRE_CONFIG.start,
                    end: GALERIA_ORFEBRE_CONFIG.end,
                    pin: true,
                    scrub: 1,
                    anticipatePin: 1,
                    invalidateOnRefresh: true,
                },
            });

            GALERIA_ORFEBRE_CONFIG.imagenes.forEach((cfg) => {
                const img = galeria.querySelector(cfg.selector);
                if (!img) return;

                tl.to(img, {
                    // Se calculan en px en cada refresh para que el %
                    // siempre sea relativo al tamaño actual de la galería
                    x: () => (galeria.offsetWidth * cfg.x) / 100,
                    y: () => (galeria.offsetHeight * cfg.y) / 100,
                    rotation: cfg.rotacion ?? 0,
                    scale: cfg.escala ?? 1,
                    ease: 'none',
                }, 0); // todas las imágenes se mueven a la vez
            });
        }
    );
}




// ==========================================================
// RELOJ ORFEBRERÍA — agujas SVG en tiempo real
// ==========================================================
// El SVG de .contenedor-orfebreria-contacto comparte viewBox con
// la imagen de la esfera (0 0 3138 4832), así que el pivote del
// mecanismo se expresa en esas mismas coordenadas.
//
// requestAnimationFrame en vez de setInterval:
//  - se sincroniza con el refresco de pantalla (sin tirones)
//  - se pausa en pestañas ocultas (ahorra CPU/batería)
//  - permite segundero fluido ("sweep") usando milisegundos
function initRelojOrfebreria() {
    const wrapper = document.querySelector('.contenedor-orfebreria-contacto .reloj-wrapper');
    if (!wrapper) return;

    // Pivote del mecanismo en coordenadas del viewBox
    const PX = 1456, PY = 2306;

    const hora = wrapper.querySelector('#reloj-hora');
    const minuto = wrapper.querySelector('#reloj-minuto');
    const segundo = wrapper.querySelector('#reloj-segundo');
    if (!hora || !minuto || !segundo) return;

    function tick() {
        const now = new Date();
        const s = now.getSeconds() + now.getMilliseconds() / 1000; // sweep continuo
        const m = now.getMinutes() + s / 60;
        const h = (now.getHours() % 12) + m / 60;

        segundo.setAttribute('transform', `translate(${PX} ${PY}) rotate(${s * 6})`);
        minuto.setAttribute('transform', `translate(${PX} ${PY}) rotate(${m * 6})`);
        hora.setAttribute('transform', `translate(${PX} ${PY}) rotate(${h * 30})`);

        requestAnimationFrame(tick);
    }
    tick();
}



/**
 * Inicializa el formulario de reserva de cita
 */
function initFormularioCita() {
    const formulario = document.getElementById('form-reservar-cita');

    if (!formulario) return;

    formulario.addEventListener('submit', function (event) {
        // Validación básica
        const fecha = formulario.querySelector('#fecha-cita').value;
        const hora = formulario.querySelector('#hora-cita').value;

        if (!fecha || !hora) {
            event.preventDefault();
            mostrarError('Por favor, completa la fecha y la hora de la cita.');
            return;
        }

        // Validar que la fecha no sea anterior a hoy
        const fechaSeleccionada = new Date(fecha + 'T' + hora);
        const ahora = new Date();

        if (fechaSeleccionada < ahora) {
            event.preventDefault();
            mostrarError('La fecha y hora de la cita no pueden ser anteriores al momento actual.');
            return;
        }

        const botonSubmit = formulario.querySelector('.btn-confirmar-cita');
        botonSubmit.disabled = true;
        botonSubmit.textContent = 'Enviando...';
        botonSubmit.style.opacity = '0.7';
    });
}

/**
 * Muestra un mensaje de error temporal
 */
function mostrarError(mensaje) {
    // Eliminar mensaje anterior si existe
    const errorAnterior = document.querySelector('.error-temporal');
    if (errorAnterior) errorAnterior.remove();

    const divError = document.createElement('div');
    divError.className = 'error-temporal';
    divError.style.cssText = `
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.3);
        color: #dc3545;
        padding: 1rem;
        border-radius: 4px;
        margin-bottom: 1.5rem;
        font-family: 'Lato', sans-serif;
        text-align: center;
        animation: fadeInUp 0.3s ease;
    `;
    divError.textContent = mensaje;

    const formulario = document.getElementById('form-reservar-cita');
    formulario.insertBefore(divError, formulario.firstChild);

    // Auto-eliminar después de 4 segundos
    setTimeout(() => {
        if (divError.parentNode) {
            divError.style.opacity = '0';
            divError.style.transition = 'opacity 0.3s ease';
            setTimeout(() => divError.remove(), 300);
        }
    }, 4000);
}

/**
 * Establece la fecha mínima como hoy
 */
function initFechaMinima() {
    const inputFecha = document.getElementById('fecha-cita');
    if (!inputFecha) return;

    const hoy = new Date().toISOString().split('T')[0];
    inputFecha.setAttribute('min', hoy);
}

/**
 * Lazy loading de imágenes específico para la página de orfebrería
 */
function initLazyLoadingOrfebreria() {
    if (!('IntersectionObserver' in window)) {
        document.querySelectorAll('img[data-src]').forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
        return;
    }

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    img.classList.add('loaded');
                }
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '100px 0px',
        threshold: 0.01
    });

    document.querySelectorAll('.orfebre-imagen img[data-src], .img-informativa[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}
