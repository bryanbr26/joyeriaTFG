// resources/js/app.js
document.addEventListener('DOMContentLoaded', function () {
    // Elementos del mega menú
    const categoriasItems = document.querySelectorAll('.categoria-item');
    const imagenElemento = document.querySelector('.img-drop-down img');
    const textoElemento = document.querySelector('.imagen-texto');

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
});