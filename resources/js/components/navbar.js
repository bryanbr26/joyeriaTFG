export function initNavbar() {
    // Mostrar Nav al hacer scroll pasado el header-icon
    const headerIconContainer = document.getElementById('header-icon');
    const mainNavBar = document.getElementById('nav-bar');
    const menuToggle = document.getElementById('menu-toggle');
    const body = document.body;

    const MOBILE_BREAKPOINT = 991;

    function isMobile() {
        return window.innerWidth <= MOBILE_BREAKPOINT;
    }

    if (headerIconContainer && mainNavBar) {
        // Si no es la página principal, hacemos que el nav sea visible por defecto al inicio
        const isHomePage = document.body.classList.contains('home-page');
        if (!isHomePage) {
            mainNavBar.classList.add('nav-visible-defecto');
        }

        function checkScrollForNav() {
            // En mobile/tablet el nav se controla por el menú hamburguesa, no por scroll
            if (isMobile()) return;

            // Umbral = la parte inferior de header-icon respecto al inicio del documento
            const threshold = headerIconContainer.offsetTop + headerIconContainer.offsetHeight;

            // Si hemos scrolleado más allá de ese punto, mostramos el nav (fixed al top)
            if (window.scrollY > threshold) {
                mainNavBar.classList.add('mostrar-nav');
            } else {
                mainNavBar.classList.remove('mostrar-nav');
            }
        }

        // Escuchar evento de scroll
        window.addEventListener('scroll', checkScrollForNav);
        // Llamar una vez por si se recargó la página con scroll
        checkScrollForNav();
    }

    // ============================================
    // MENÚ HAMBURGUESA
    // ============================================
    if (menuToggle && mainNavBar) {
        menuToggle.addEventListener('click', (e) => {
            e.preventDefault();
            const estaAbierto = mainNavBar.classList.toggle('nav-abierto');

            // Bloquear/desbloquear scroll del body cuando el menú esté abierto
            if (estaAbierto) {
                body.style.overflow = 'hidden';
            } else {
                body.style.overflow = '';
                // Cerrar dropdowns al cerrar el menú
                mainNavBar.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));
            }
        });
    }

    // ============================================
    // BOTÓN CERRAR DEL NAV-BAR
    // ============================================
    const navClose = document.getElementById('nav-close');
    if (navClose && mainNavBar) {
        navClose.addEventListener('click', () => {
            mainNavBar.classList.remove('nav-abierto');
            body.style.overflow = '';
            mainNavBar.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));
        });
    }

    // ============================================
    // DROPDOWNS EN MOBILE/TABLET
    // ============================================
    if (mainNavBar) {
        const dropdownItems = mainNavBar.querySelectorAll('.dropdown');

        dropdownItems.forEach(dropdown => {
            const link = dropdown.querySelector('.nav-link');
            if (!link) return;

            link.addEventListener('click', (e) => {
                if (!isMobile()) return; // En desktop dejamos el comportamiento hover nativo

                // Si ya está abierto, lo cerramos; si no, cerramos los demás y abrimos este
                const isOpen = dropdown.classList.contains('show');
                const href = link.getAttribute('href');

                if (isOpen && href && href !== '#') {
                    return;
                }

                e.preventDefault();

                // Cerrar todos los demás dropdowns del mismo nivel
                dropdownItems.forEach(d => {
                    if (d !== dropdown) d.classList.remove('show');
                });

                dropdown.classList.toggle('show', !isOpen);
            });
        });

        // Cerrar el menú completo al pulsar un link normal (sin dropdown)
        mainNavBar.querySelectorAll('.nav-item:not(.dropdown) > .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (isMobile() && mainNavBar.classList.contains('nav-abierto')) {
                    mainNavBar.classList.remove('nav-abierto');
                    body.style.overflow = '';
                }
            });
        });
    }

    // ============================================
    // LIMPIAR AL REDIMENSIONAR A DESKTOP
    // ============================================
    window.addEventListener('resize', () => {
        if (!isMobile() && mainNavBar) {
            mainNavBar.classList.remove('nav-abierto');
            body.style.overflow = '';
            mainNavBar.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));
        }
    });
}
