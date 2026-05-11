// resources/js/app.js
document.addEventListener('DOMContentLoaded', function () {
    // Elementos del mega menú
    const categoriasItems = document.querySelectorAll('.categoria-item');
    const imagenElemento = document.querySelector('.img-drop-down img');
    const textoElemento = document.querySelector('.imagen-texto');
    const botonBuscador = document.getElementById('boton-buscador');
    const overlayBuscador = document.getElementById('overlay-buscador');
    const cerrarBuscador = document.getElementById('cerrar-buscador');

    // Imagen por defecto
    const imagenDefault = {
        url: '/images/joyas/default.jpg',
        texto: 'Descubre nuestra colección exclusiva'
    };

    // Función para cambiar imagen con fade
    function cambiarImagen(nuevaUrl, nuevoTexto) {
        if (!imagenElemento) return;

        // Efecto fade out
        imagenElemento.style.opacity = '0';

        setTimeout(() => {
            imagenElemento.src = nuevaUrl;
            if (textoElemento) {
                textoElemento.textContent = nuevoTexto;
            }
            // Efecto fade in
            imagenElemento.style.opacity = '1';
        }, 150);
    }

    // Función para resetear imagen
    function resetearImagen() {
        cambiarImagen(imagenDefault.url, imagenDefault.texto);
    }

    // Agregar event listeners a cada categoría
    if (categoriasItems.length > 0) {
        categoriasItems.forEach(item => {
            item.addEventListener('mouseenter', function () {
                const imagenUrl = this.getAttribute('data-imagen');
                const texto = this.querySelector('a')?.textContent || 'Categoría';

                if (imagenUrl) {
                    cambiarImagen(imagenUrl, `Explora nuestra colección de ${texto.toLowerCase()}`);
                }
            });
        });

        // Resetear cuando el mouse sale del menú
        const dropdownMenu = document.querySelector('.dropdown-menu');
        if (dropdownMenu) {
            dropdownMenu.addEventListener('mouseleave', function () {
                resetearImagen();
            });
        }
    }
    // Abrir overlay
    if (botonBuscador) {
        botonBuscador.addEventListener('click', function (e) {
            e.preventDefault();
            overlayBuscador.classList.add('active');
            document.body.style.overflow = 'hidden'; // Evita scroll del body

            // Opcional: Enfocar el input
            setTimeout(() => {
                const input = document.getElementById('buscador');
                if (input) input.focus();
            }, 300);
        });
    }

    // Cerrar overlay
    function cerrarOverlay() {
        overlayBuscador.classList.remove('active');
        document.body.style.overflow = ''; // Restaurar scroll
    }

    if (cerrarBuscador) {
        cerrarBuscador.addEventListener('click', cerrarOverlay);
    }

    // Cerrar al hacer clic fuera del panel
    if (overlayBuscador) {
        overlayBuscador.addEventListener('click', function (e) {
            if (e.target === overlayBuscador) {
                cerrarOverlay();
            }
        });
    }

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
});