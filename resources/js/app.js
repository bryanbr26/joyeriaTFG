import './bootstrap';
import 'bootstrap';

import { initMegaMenu } from './components/mega-menu.js';
import { initBuscador } from './components/buscador.js';
import { initNavbar } from './components/navbar.js';

document.addEventListener('DOMContentLoaded', function () {
    // Inicializar componentes globales
    initMegaMenu();
    initBuscador();
    initNavbar();

    // Lazy loading de imágenes con Intersection Observer
    initLazyLoading();
});

function initLazyLoading() {
    if (!('IntersectionObserver' in window)) {
        // Fallback: cargar todas las imágenes inmediatamente
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
                }
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '50px 0px',
        threshold: 0.01
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}
