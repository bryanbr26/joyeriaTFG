import './bootstrap';
import 'bootstrap';

import { initMegaMenu } from './components/mega-menu.js';
import { initBuscador } from './components/buscador.js';
import { initNavbar } from './components/navbar.js';

// ==========================================================
// Loader – Lógica completa de espera y ocultación
// ==========================================================
let loaderHidden = false;
const LOADER_TIMEOUT = 8000; // 8 segundos máximo (fallback de seguridad)

function hideLoader() {
    if (loaderHidden) return;
    loaderHidden = true;

    const loader = document.getElementById('page-loader');
    if (!loader) return;

    // Agregar clase de salida para transición suave
    loader.classList.add('loader-hidden');

    // Avisar a lectores de pantalla
    loader.removeAttribute('aria-hidden');
    loader.setAttribute('role', 'alert');
    loader.setAttribute('aria-live', 'polite');
    loader.setAttribute('aria-label', 'Página completamente cargada');

    // Eliminar del DOM tras la animación (700ms inline CSS + margen)
    setTimeout(() => {
        loader.style.display = 'none';
    }, 750);
}

/**
 * Espera a que un elemento multimedia (video/audio) esté listo.
 */
function waitForMedia(media) {
    return new Promise((resolve) => {
        if (!media) return resolve();
        if (media.readyState >= 2) return resolve(); // HAVE_CURRENT_DATA

        const onReady = () => {
            media.removeEventListener('loadedmetadata', onReady);
            media.removeEventListener('canplay', onReady);
            media.removeEventListener('error', onReady);
            resolve();
        };

        media.addEventListener('loadedmetadata', onReady);
        media.addEventListener('canplay', onReady);
        media.addEventListener('error', onReady); // No bloquear por error
    });
}

/**
 * Espera a que todas las imágenes con src real (no placeholders lazy)
 * que están en el viewport inicial terminen de cargar.
 * También espera las imágenes eager.
 */
function waitForVisibleImages() {
    return new Promise((resolve) => {
        const allImages = Array.from(document.querySelectorAll('img'));
        const viewportH = window.innerHeight || document.documentElement.clientHeight;

        const criticalImages = allImages.filter(img => {
            // Ignorar imágenes sin src o con src de placeholder SVG inline
            if (!img.src || img.src.startsWith('data:image/svg+xml')) return false;

            // Si tiene data-src y NO está en el viewport, no es crítica ahora
            if (img.dataset.src) {
                const rect = img.getBoundingClientRect();
                const inViewport = rect.top < viewportH && rect.bottom > 0;
                return inViewport;
            }

            // Imágenes con loading="eager" o sin lazy explícito son críticas
            return img.loading !== 'lazy';
        });

        if (criticalImages.length === 0) return resolve();

        let pending = criticalImages.length;
        const onDone = () => {
            pending--;
            if (pending <= 0) resolve();
        };

        criticalImages.forEach(img => {
            if (img.complete && img.naturalWidth > 0) {
                onDone();
            } else {
                img.addEventListener('load', onDone, { once: true });
                img.addEventListener('error', onDone, { once: true });
            }
        });

        // Fallback por si alguna imagen nunca dispara evento
        setTimeout(resolve, 3000);
    });
}

/**
 * Espera a que los scripts con defer se hayan ejecutado.
 * En la práctica, cuando DOMContentLoaded + window.onload han pasado,
 * los scripts defer ya corrieron. Pero verificamos explícitamente
 * que los componentes globales estén inicializados.
 */
function waitForDeferredScripts() {
    return new Promise((resolve) => {
        // Los scripts defer corren después de DOMContentLoaded y antes de window.onload
        // Si window.onload ya pasó, estamos seguros.
        if (document.readyState === 'complete') return resolve();
        window.addEventListener('load', resolve, { once: true });
    });
}

/**
 * Pipeline de carga completa.
 */
async function initLoader() {
    const startTime = performance.now();

    // 1. Timeout máximo de seguridad (fallback)
    const timeoutId = setTimeout(() => {
        if (!loaderHidden) {
            console.warn('[Loader] Timeout de 8 segundos alcanzado. Ocultando loader forzosamente.');
            hideLoader();
        }
    }, LOADER_TIMEOUT);

    try {
        // Paso 1: HTML parseado
        if (document.readyState === 'loading') {
            await new Promise(r => document.addEventListener('DOMContentLoaded', r, { once: true }));
        }

        // Paso 2: Scripts defer ejecutados
        await waitForDeferredScripts();

        // Paso 3: Fuentes web cargadas
        if (document.fonts && document.fonts.ready) {
            await document.fonts.ready;
        }

        // Paso 4: Imágenes críticas del viewport inicial cargadas
        await waitForVisibleImages();

        // Paso 5: Video listo (metadata suficiente para reproducir)
        const heroVideo = document.getElementById('hero-video');
        await waitForMedia(heroVideo);

        // Paso 6: Tiempo extra de seguridad para paint final
        await new Promise(r => setTimeout(r, 400));

        clearTimeout(timeoutId);
        hideLoader();

        const elapsed = Math.round(performance.now() - startTime);
        console.log(`[Loader] Ocultado tras ${elapsed}ms.`);
    } catch (err) {
        clearTimeout(timeoutId);
        console.error('[Loader] Error en pipeline de carga:', err);
        hideLoader();
    }
}

// Iniciar pipeline del loader inmediatamente
initLoader();

// ==========================================================
// Lazy loading de imágenes con Intersection Observer
// ==========================================================
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
            loadLazyImage(img);
        });
        return;
    }

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                loadLazyImage(img);
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '100px 0px',
        threshold: 0.01
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

/**
 * Carga una imagen lazy con efecto blur-up.
 * Si la imagen tiene la clase .blur-up, espera a que cargue para quitar el desenfoque.
 */
function loadLazyImage(img) {
    if (!img.dataset.src) {
        return;
    }

    const newSrc = img.dataset.src;

    if (img.classList.contains('blur-up')) {
        const tempImg = new Image();
        tempImg.onload = function () {
            img.src = newSrc;
            img.classList.add('loaded');
            img.removeAttribute('data-src');
        };
        tempImg.onerror = function () {
            img.src = newSrc;
            img.classList.add('loaded');
            img.removeAttribute('data-src');
        };
        tempImg.src = newSrc;
    } else {
        img.src = newSrc;
        img.removeAttribute('data-src');
    }
}
