(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/pages/panel-carrito"],{

/***/ "./resources/js/pages/panel-carrito.js":
/*!*********************************************!*\
  !*** ./resources/js/pages/panel-carrito.js ***!
  \*********************************************/
/***/ (() => {

if (document.getElementById('panelCarrito') || document.querySelector('.fondo-carrito')) {
  initPanelCarrito();
}
function initPanelCarrito() {
  var panelCarrito = document.getElementById('panelCarrito');
  var panelOverlay = document.getElementById('panelOverlayCarrito');
  var btnClose = document.getElementById('closeCarrito');
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
  document.addEventListener('click', function (e) {
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
  var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  function actualizarCantidad(itemId, nuevaCantidad) {
    fetch("/carrito/".concat(itemId, "/cantidad"), {
      method: 'PATCH',
      headers: {
        'X-CSRF-TOKEN': token,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        cantidad: nuevaCantidad
      })
    }).then(function (response) {
      return response.json();
    }).then(function (data) {
      if (data.success) {
        // Actualizar cantidad mostrada del item modificado
        var qtyEl = document.getElementById('qty-' + itemId);
        if (qtyEl) qtyEl.textContent = data.cantidad;

        // Actualizar subtotal del item
        var subtotalEl = document.getElementById('subtotal-' + itemId);
        if (subtotalEl) subtotalEl.textContent = data.subtotal + '€';

        // Actualizar total general
        var totalPriceEl = document.getElementById('totalPrice');
        if (totalPriceEl) totalPriceEl.textContent = data.totalPrice + '€';
        var totalItemsEl = document.getElementById('totalItems');
        if (totalItemsEl) totalItemsEl.textContent = data.totalItems;
        var cartCount = document.getElementById('cart-count');
        if (cartCount) {
          cartCount.textContent = data.totalItems;
        }

        // Actualizar botones de TODAS las líneas del mismo producto
        if (data.itemsActualizados) {
          data.itemsActualizados.forEach(function (linea) {
            var minusBtn = document.querySelector(".btn-qty-minus[data-item-id=\"".concat(linea.id, "\"]"));
            var plusBtn = document.querySelector(".btn-qty-plus[data-item-id=\"".concat(linea.id, "\"]"));
            var stockInfo = document.getElementById('stock-info-' + linea.id);
            if (minusBtn) minusBtn.disabled = linea.cantidad <= 1;
            if (plusBtn) {
              plusBtn.dataset.maxStock = linea.maxDisponible;
              plusBtn.disabled = linea.cantidad >= linea.maxDisponible;
            }
            if (stockInfo) stockInfo.textContent = '(' + linea.maxDisponible + ' máx.)';
          });
        }
      }
    })["catch"](function (err) {
      console.error('Error:', err);
    });
  }

  // Botones de incrementar/decrementar cantidad
  document.querySelectorAll('.btn-qty-minus').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var itemId = this.dataset.itemId;
      var qtyEl = document.getElementById('qty-' + itemId);
      var currentQty = qtyEl ? parseInt(qtyEl.textContent) : 1;
      if (currentQty > 1) {
        actualizarCantidad(itemId, currentQty - 1);
      }
    });
  });
  document.querySelectorAll('.btn-qty-plus').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var itemId = this.dataset.itemId;
      var qtyEl = document.getElementById('qty-' + itemId);
      var currentQty = qtyEl ? parseInt(qtyEl.textContent) : 1;
      var maxStock = parseInt(this.dataset.maxStock);
      if (currentQty < maxStock) {
        actualizarCantidad(itemId, currentQty + 1);
      }
    });
  });
}

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ var __webpack_exports__ = (__webpack_exec__("./resources/js/pages/panel-carrito.js"));
/******/ }
]);
//# sourceMappingURL=panel-carrito.js.map