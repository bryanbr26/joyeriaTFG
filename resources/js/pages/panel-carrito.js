export function initPanelCarrito() {
    const panelCarrito = document.getElementById('panelCarrito');
    const panelOverlay = document.getElementById('panelOverlayCarrito');
    const btnClose = document.getElementById('closeCarrito');
    // We use event delegation or attach directly. For Seguir comprando it might be replaced on DOM update.
    
    function openPanel() {
        if (panelCarrito) {
            panelCarrito.classList.add('activo');
            if (panelOverlay) {
                panelOverlay.classList.add('activo');
            }
            document.body.style.overflow = 'hidden'; // Evitar scroll
        }
    }

    function closePanel() {
        if (panelCarrito) {
            panelCarrito.classList.remove('activo');
            if (panelOverlay) {
                panelOverlay.classList.remove('activo');
            }
            document.body.style.overflow = ''; // Restaurar scroll
        }
    }

    // Escuchar el evento personalizado lanzado cuando se añade a la cesta
    document.addEventListener('openCartPanel', openPanel);

    // Eventos para cerrar el panel
    if (btnClose) {
        btnClose.addEventListener('click', closePanel);
    }
    
    if (panelOverlay) {
        panelOverlay.addEventListener('click', closePanel);
    }

    // Delegación de eventos porque los botones pueden ser reemplazados por AJAX
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'btnSeguirComprando') {
            closePanel();
        }
        // Cerrar al pulsar el botón de cerrar dinámico también
        if (e.target && e.target.id === 'closeCarrito') {
            closePanel();
        }
    });
}
