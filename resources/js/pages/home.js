if (document.querySelector('.carrusel-joyas')) {
    initHomeCarousel();
}

function initHomeCarousel() {
    const carrusel = document.querySelector('.carrusel-joyas');
    if (!carrusel) return;

    const originalChildren = Array.from(carrusel.children);

    // Duplicar elementos para el efecto de scroll infinito
    originalChildren.forEach(child => {
        const clone = child.cloneNode(true);
        carrusel.appendChild(clone);
    });

    const tarjetas = carrusel.querySelectorAll('.tarjeta');

    let isDown = false;
    let startX;
    let scrollLeft;
    let currentSpeed = 0.6;
    const baseSpeed = 0.6;
    let hoverCount = 0; // Contador para manejar múltiples tarjetas en hover
    let isDragging = false;
    let rafId = null;

    // Detectar si es pantalla pequeña (menor a 992px)
    const isMobileOrTablet = window.matchMedia('(max-width: 991px)').matches;

    function checkBoundary() {
        const firstCard = originalChildren[0];
        const gap = parseFloat(getComputedStyle(carrusel).gap) || 0;
        const originalWidth = (firstCard.offsetWidth + gap) * originalChildren.length;

        if (carrusel.scrollLeft >= originalWidth) {
            carrusel.scrollLeft -= originalWidth;
        } else if (carrusel.scrollLeft <= 0) {
            carrusel.scrollLeft += originalWidth;
        }
    }

    function autoScroll() {
        // No auto-scroll en móvil/tablet para ahorrar batería y mejorar rendimiento
        if (isMobileOrTablet) return;

        const targetSpeed = (hoverCount > 0 || isDown) ? 0 : baseSpeed;

        // Interpolación suave de velocidad
        currentSpeed += (targetSpeed - currentSpeed) * 0.08;

        // Si la velocidad es muy baja y estamos en hover/drag, la forzamos a 0
        if (hoverCount > 0 || isDown) {
            if (Math.abs(currentSpeed) < 0.005) {
                currentSpeed = 0;
            }
        }

        if (Math.abs(currentSpeed) > 0.001) {
            carrusel.scrollLeft += currentSpeed;
            checkBoundary();
        }

        rafId = requestAnimationFrame(autoScroll);
    }

    // Eventos del ratón para arrastrar
    carrusel.addEventListener('mousedown', (e) => {
        isDown = true;
        isDragging = false;
        carrusel.classList.add('dragging');
        startX = e.pageX - carrusel.offsetLeft;
        scrollLeft = carrusel.scrollLeft;
    });

    carrusel.addEventListener('mouseleave', () => {
        if (isDown) {
            isDown = false;
            isDragging = false;
            carrusel.classList.remove('dragging');
        }
    });

    carrusel.addEventListener('mouseup', () => {
        isDown = false;
        carrusel.classList.remove('dragging');
        setTimeout(() => {
            isDragging = false;
        }, 50);
    });

    carrusel.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        isDragging = true;
        const x = e.pageX - carrusel.offsetLeft;
        const walk = (x - startX) * 1.5;
        carrusel.scrollLeft = scrollLeft - walk;
        checkBoundary();
    });

    // Pausa suave al pasar el ratón sobre cada tarjeta individual
    tarjetas.forEach(tarjeta => {
        tarjeta.addEventListener('mouseenter', () => {
            hoverCount++;
        });

        tarjeta.addEventListener('mouseleave', () => {
            hoverCount = Math.max(0, hoverCount - 1);
        });
    });

    // Eventos táctiles para móviles
    carrusel.addEventListener('touchstart', (e) => {
        isDown = true;
        startX = e.touches[0].pageX - carrusel.offsetLeft;
        scrollLeft = carrusel.scrollLeft;
    }, { passive: true });

    carrusel.addEventListener('touchend', () => {
        isDown = false;
    });

    carrusel.addEventListener('touchmove', (e) => {
        if (!isDown) return;
        const x = e.touches[0].pageX - carrusel.offsetLeft;
        const walk = (x - startX) * 2;
        carrusel.scrollLeft = scrollLeft - walk;
        checkBoundary();
    }, { passive: true });

    // Interceptar clics en el carrusel si estábamos arrastrando
    carrusel.addEventListener('click', (e) => {
        if (isDragging) {
            e.preventDefault();
            e.stopPropagation();
        }
    }, true);

    // Iniciar scroll automático
    rafId = requestAnimationFrame(autoScroll);
}
