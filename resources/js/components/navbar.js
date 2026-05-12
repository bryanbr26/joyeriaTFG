export function initNavbar() {
    // Mostrar Nav al hacer scroll pasado el header-icon
    const headerIconContainer = document.getElementById('header-icon');
    const mainNavBar = document.getElementById('nav-bar');

    if (headerIconContainer && mainNavBar) {
        // Si no es la página principal, hacemos que el nav sea visible por defecto al inicio
        const isHomePage = document.body.classList.contains('home-page');
        if (!isHomePage) {
            mainNavBar.classList.add('nav-visible-defecto');
        }

        function checkScrollForNav() {
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
}
