import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initProductosShow() {
    const imagenCol = document.querySelector('.producto-detalle-imagen');
    const infoCol = document.querySelector('.producto-info');

    if (!imagenCol || !infoCol) return;

    // Solo activar en escritorio (>= 768px)
    const mediaQuery = window.matchMedia('(min-width: 768px)');

    let scrollTriggerInstance = null;

    function crearScrollTrigger() {
        if (scrollTriggerInstance) return; // Ya está creado

        scrollTriggerInstance = ScrollTrigger.create({
            trigger: '.producto-detalle-grid',
            start: 'top top',
            end: () => `+=${imagenCol.offsetHeight - infoCol.offsetHeight}`,
            pin: infoCol,
            pinSpacing: false,
            anticipatePin: 1,
            invalidateOnRefresh: true,
        });
    }

    function destruirScrollTrigger() {
        if (scrollTriggerInstance) {
            scrollTriggerInstance.kill();
            scrollTriggerInstance = null;
        }
    }

    // Evaluar al cargar
    function evaluarMediaQuery(e) {
        if (e.matches) {
            crearScrollTrigger();
        } else {
            destruirScrollTrigger();
        }
    }

    // Escuchar cambios de tamaño de pantalla
    mediaQuery.addEventListener('change', evaluarMediaQuery);

    // Refrescar ScrollTrigger cuando se despliegan las descripciones informativas
    // para recalcular la altura de la columna y el punto de pin
    document.querySelectorAll('.dropdown-custom .dropdown-header').forEach(header => {
        header.addEventListener('click', () => {
            // Esperar un poco a que la transición de CSS termine (0.3s en SCSS)
            setTimeout(() => {
                ScrollTrigger.refresh();
            }, 400);
        });
    });

    // Ejecutar al inicio
    evaluarMediaQuery(mediaQuery);
}