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

    // Efecto scroll para el header
    let lastScrollTop = 0;
    const headerElement = document.querySelector('header');
    const scrollThreshold = 50;
    const navShowThreshold = 300; // Distancia desde el tope para solo mostrar el nav

    window.addEventListener('scroll', function () {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop && scrollTop > scrollThreshold) {
            // Scroll hacia abajo - Ocultar todo
            headerElement.classList.add('header-hidden');
            headerElement.classList.remove('header-nav-only');
        } else {
            // Scroll hacia arriba
            if (scrollTop > navShowThreshold) {
                // Lejos del tope: Solo mostramos la fila del nav-bar
                headerElement.classList.remove('header-hidden');
                headerElement.classList.add('header-nav-only');
            } else {
                // Cerca del tope: Mostramos todo el header original
                headerElement.classList.remove('header-hidden');
                headerElement.classList.remove('header-nav-only');
            }
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }, false);
});