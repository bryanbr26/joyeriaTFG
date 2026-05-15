export function initBuscador() {
    const botonBuscador = document.getElementById('boton-buscador');
    const overlayBuscador = document.getElementById('overlay-buscador');
    const cerrarBuscador = document.getElementById('cerrar-buscador');

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
}
