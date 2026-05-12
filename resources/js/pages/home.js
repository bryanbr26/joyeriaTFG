export function initHomeCarousel() {
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
}
