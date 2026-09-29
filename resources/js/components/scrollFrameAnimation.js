import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

gsap.registerPlugin(ScrollTrigger);

/**
 * Puente estándar Lenis + ScrollTrigger.
 * Si ya existe una instancia global de Lenis (window.__lenis) la reutiliza
 * y NO la duplica; solo asegura que esté sincronizada con ScrollTrigger.
 */
function initLenisBridge() {
    if (window.__lenis) return window.__lenis;

    const lenis = new Lenis();

    // ScrollTrigger se actualiza en cada evento de scroll de Lenis
    lenis.on('scroll', ScrollTrigger.update);

    // Lenis se actualiza dentro del ticker de GSAP (un solo requestAnimationFrame)
    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });

    // Evita saltos de la animación cuando el ticker recupera tiempo perdido
    gsap.ticker.lagSmoothing(0);

    window.__lenis = lenis;
    return lenis;
}

/**
 * Animación frame-by-frame controlada por scroll sobre un <canvas>.
 *
 * - Pina la sección con ScrollTrigger mientras el scroll recorre los frames.
 * - Bajar → frames ascendentes; subir → reversa (scrub bidireccional).
 * - Precarga progresiva: dibuja el frame 0 cuanto antes y carga el resto
 *   en segundo plano sin bloquear la página.
 * - En móvil o con prefers-reduced-motion no hay pin: frame 0 estático.
 *
 * Configuración vía data-attributes del canvas:
 *   data-frames-base   Ruta base de los frames (p. ej. /images/frames)
 *   data-total-frames  Número total de frames (p. ej. 119)
 *   data-pin-end       Recorrido del pin (p. ej. "+=200%")
 *
 * @param {string} sectionSelector Selector de la sección a pinear.
 */
export function initScrollFrameAnimation(sectionSelector = '.section-uno') {
    const section = document.querySelector(sectionSelector);
    if (!section) return;

    const canvas = section.querySelector('canvas.frames-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    // --- Configuración leída del HTML ---
    const framesBase = canvas.dataset.framesBase || '/images/frames';
    const totalFrames = parseInt(canvas.dataset.totalFrames, 10) || 119;
    const pinEnd = canvas.dataset.pinEnd || '+=200%';

    // Nombre de archivo con padding de 3 dígitos: frame_001.jpg … frame_119.jpg
    const frameUrl = (i) => `${framesBase}/frame_${String(i + 1).padStart(3, '0')}.jpg`;

    const images = new Array(totalFrames);
    const loaded = new Array(totalFrames).fill(false);
    let currentIndex = 0;

    // --- Dibujo tipo object-fit: cover (recorte sin deformar) ---
    function drawCover(img) {
        const cw = canvas.width;
        const ch = canvas.height;
        if (!cw || !ch || !img.naturalWidth) return;

        const scale = Math.max(cw / img.naturalWidth, ch / img.naturalHeight);
        const sw = cw / scale;
        const sh = ch / scale;
        const sx = (img.naturalWidth - sw) / 2;
        const sy = (img.naturalHeight - sh) / 2;

        ctx.drawImage(img, sx, sy, sw, sh, 0, 0, cw, ch);
    }

    // Devuelve el índice cargado más cercano al pedido (-1 si no hay ninguno)
    function nearestLoadedIndex(index) {
        for (let offset = 0; offset < totalFrames; offset++) {
            const down = index - offset;
            const up = index + offset;
            if (down >= 0 && loaded[down]) return down;
            if (up < totalFrames && loaded[up]) return up;
        }
        return -1;
    }

    // Dibuja el frame pedido; si aún no está cargado, el cargado más cercano
    function renderFrame(index) {
        const idx = loaded[index] ? index : nearestLoadedIndex(index);
        if (idx === -1) return;
        drawCover(images[idx]);
    }

    // Ajusta la resolución del canvas al tamaño CSS × devicePixelRatio
    // y redibuja (cambiar width/height borra el contenido del canvas)
    function resizeCanvas() {
        const dpr = window.devicePixelRatio || 1;
        const rect = canvas.getBoundingClientRect();
        canvas.width = Math.round(rect.width * dpr);
        canvas.height = Math.round(rect.height * dpr);
        renderFrame(currentIndex);
    }

    // Carga un frame como promesa; un error no rompe la cadena de precarga
    function loadFrame(i) {
        return new Promise((resolve) => {
            const img = new Image();
            img.decoding = 'async';
            img.src = frameUrl(i);
            img.onload = () => {
                loaded[i] = true;
                resolve();
            };
            img.onerror = () => resolve();
            images[i] = img;
        });
    }

    // Precarga el resto de frames en segundo plano con concurrencia limitada
    function preloadRemaining() {
        const concurrency = 6;
        let next = 1;
        const worker = () => {
            if (next >= totalFrames) return;
            const i = next++;
            loadFrame(i).then(worker);
        };
        for (let k = 0; k < concurrency; k++) worker();
    }

    // --- Arranque: frame 0 inmediato, resto en segundo plano ---
    resizeCanvas();
    loadFrame(0).then(() => {
        renderFrame(0);
        preloadRemaining();
    });

    window.addEventListener('resize', resizeCanvas);

    // --- Pin con ScrollTrigger (solo escritorio y sin reduced-motion) ---
    initLenisBridge();

    const mm = gsap.matchMedia();

    mm.add(
        {
            isDesktop: '(min-width: 992px)',
            reduceMotion: '(prefers-reduced-motion: reduce)',
        },
        (context) => {
            const { isDesktop, reduceMotion } = context.conditions;

            // Móvil o movimiento reducido: sin pin, primer frame estático
            if (!isDesktop || reduceMotion) {
                currentIndex = 0;
                renderFrame(0);
                return;
            }

            ScrollTrigger.create({
                trigger: section,
                start: 'top top',
                end: pinEnd,
                pin: true,
                scrub: 1,
                anticipatePin: 1,
                invalidateOnRefresh: true,
                onUpdate: (self) => {
                    // Índice entero sincronizado con el progreso del scroll.
                    // Solo se redibuja cuando el índice cambia.
                    const index = Math.round(self.progress * (totalFrames - 1));
                    if (index !== currentIndex) {
                        currentIndex = index;
                        renderFrame(index);
                    }
                },
            });
        }
    );
}
