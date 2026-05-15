if (document.getElementById('panelCarrito') || document.querySelector('.fondo-carrito')) {
    initPanelCarrito();
}

function initPanelCarrito() {
    const panelCarrito = document.getElementById('panelCarrito');
    const panelOverlay = document.getElementById('panelOverlayCarrito');
    const btnClose = document.getElementById('closeCarrito');

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

    // ==========================================
    // Lógica de cantidades en página de carrito
    // ==========================================
    if (!document.querySelector('.fondo-carrito')) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function actualizarCantidad(itemId, nuevaCantidad) {
        fetch(`/carrito/${itemId}/cantidad`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cantidad: nuevaCantidad })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Actualizar cantidad mostrada del item modificado
                const qtyEl = document.getElementById('qty-' + itemId);
                if (qtyEl) qtyEl.textContent = data.cantidad;

                // Actualizar subtotal del item
                const subtotalEl = document.getElementById('subtotal-' + itemId);
                if (subtotalEl) subtotalEl.textContent = data.subtotal + '€';

                // Actualizar total general
                const totalPriceEl = document.getElementById('totalPrice');
                if (totalPriceEl) totalPriceEl.textContent = data.totalPrice + '€';

                const totalItemsEl = document.getElementById('totalItems');
                if (totalItemsEl) totalItemsEl.textContent = data.totalItems;

                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.totalItems;
                }

                // Actualizar botones de TODAS las líneas del mismo producto
                if (data.itemsActualizados) {
                    data.itemsActualizados.forEach(function(linea) {
                        const minusBtn = document.querySelector(`.btn-qty-minus[data-item-id="${linea.id}"]`);
                        const plusBtn = document.querySelector(`.btn-qty-plus[data-item-id="${linea.id}"]`);
                        const stockInfo = document.getElementById('stock-info-' + linea.id);

                        if (minusBtn) minusBtn.disabled = (linea.cantidad <= 1);
                        if (plusBtn) {
                            plusBtn.dataset.maxStock = linea.maxDisponible;
                            plusBtn.disabled = (linea.cantidad >= linea.maxDisponible);
                        }
                        if (stockInfo) stockInfo.textContent = '(' + linea.maxDisponible + ' máx.)';
                    });
                }
            }
        })
        .catch(err => {
            console.error('Error:', err);
        });
    }

    // Botones de incrementar/decrementar cantidad
    document.querySelectorAll('.btn-qty-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const qtyEl = document.getElementById('qty-' + itemId);
            const currentQty = qtyEl ? parseInt(qtyEl.textContent) : 1;
            if (currentQty > 1) {
                actualizarCantidad(itemId, currentQty - 1);
            }
        });
    });

    document.querySelectorAll('.btn-qty-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const qtyEl = document.getElementById('qty-' + itemId);
            const currentQty = qtyEl ? parseInt(qtyEl.textContent) : 1;
            const maxStock = parseInt(this.dataset.maxStock);
            if (currentQty < maxStock) {
                actualizarCantidad(itemId, currentQty + 1);
            }
        });
    });
}
