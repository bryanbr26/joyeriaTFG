// resources/js/app.js
(function () {
    function closeDropdown(dropdown) {
        const toggle = dropdown.querySelector('[data-bs-toggle="dropdown"]');
        const menu = dropdown.querySelector('.dropdown-menu');

        if (!toggle || !menu) return;

        toggle.classList.remove('show');
        toggle.setAttribute('aria-expanded', 'false');
        menu.classList.remove('show');
    }

    function closeAllDropdowns(exceptDropdown = null) {
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            if (dropdown !== exceptDropdown && !dropdown.classList.contains('joyeria-mega-dropdown')) {
                closeDropdown(dropdown);
            }
        });
    }

    function openModal(modal) {
        if (!modal) return;

        closeModal(document.querySelector('.modal.show'));

        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.dataset.generatedBackdrop = 'true';
        document.body.appendChild(backdrop);

        modal.style.display = 'block';
        modal.removeAttribute('aria-hidden');
        modal.setAttribute('aria-modal', 'true');
        modal.classList.add('show');
        document.body.classList.add('modal-open');

        const closeButton = modal.querySelector('[data-bs-dismiss="modal"], .btn-close');
        if (closeButton) {
            closeButton.focus();
        }
    }

    function closeModal(modal) {
        if (!modal) return;

        modal.classList.remove('show');
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        modal.removeAttribute('aria-modal');
        document.body.classList.remove('modal-open');

        document.querySelectorAll('[data-generated-backdrop="true"]').forEach(backdrop => backdrop.remove());
    }

    window.bootstrap = window.bootstrap || {};
    window.bootstrap.Modal = window.bootstrap.Modal || function (modal) {
        return {
            show: function () {
                openModal(modal);
            },
            hide: function () {
                closeModal(modal);
            }
        };
    };

    document.addEventListener('click', function (event) {
        const dropdownToggle = event.target.closest('[data-bs-toggle="dropdown"]');
        if (dropdownToggle) {
            event.preventDefault();

            const dropdown = dropdownToggle.closest('.dropdown');
            const menu = dropdown ? dropdown.querySelector('.dropdown-menu') : null;
            if (!dropdown || !menu || dropdown.classList.contains('joyeria-mega-dropdown')) return;

            const isOpen = menu.classList.contains('show');
            closeAllDropdowns(dropdown);

            dropdownToggle.classList.toggle('show', !isOpen);
            dropdownToggle.setAttribute('aria-expanded', String(!isOpen));
            menu.classList.toggle('show', !isOpen);
            return;
        }

        const modalToggle = event.target.closest('[data-bs-toggle="modal"]');
        if (modalToggle) {
            event.preventDefault();
            openModal(document.querySelector(modalToggle.dataset.bsTarget));
            return;
        }

        const dismissModal = event.target.closest('[data-bs-dismiss="modal"]');
        if (dismissModal) {
            event.preventDefault();
            closeModal(dismissModal.closest('.modal'));
            return;
        }

        const openedDropdown = event.target.closest('.dropdown');
        if (!openedDropdown || openedDropdown.querySelector('[data-bs-auto-close="outside"]') === null) {
            closeAllDropdowns(openedDropdown);
        }

        if (event.target.classList.contains('modal')) {
            closeModal(event.target);
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAllDropdowns();
            closeModal(document.querySelector('.modal.show'));
        }
    });
})();

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
        url: '/images/joyas/exclusiva.webp',
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
        const dropdownMenu = document.querySelector('.joyeria-mega-menu');
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
            if (!overlayBuscador) return;
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
        if (!overlayBuscador) return;
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
