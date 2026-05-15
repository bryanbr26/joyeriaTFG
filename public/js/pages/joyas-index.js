(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/pages/joyas-index"],{

/***/ "./resources/js/pages/joyas-index.js":
/*!*******************************************!*\
  !*** ./resources/js/pages/joyas-index.js ***!
  \*******************************************/
/***/ (() => {

if (document.getElementById('page-joyas')) {
  initJoyasIndex();
}
function initJoyasIndex() {
  // Toggles de Paneles
  var botonFilter = document.getElementById('boton-filter');
  var botonOrdenar = document.getElementById('boton-ordenar');
  var panelFiltrar = document.getElementById('panelFiltrar');
  var panelOrdenar = document.getElementById('panelOrdenar');
  var panelOverlay = document.getElementById('panelOverlay');
  var closeFilter = document.getElementById('closeFilter');
  var closeSort = document.getElementById('closeSort');
  function togglePanel(panel) {
    if (!panel) return;
    panel.classList.add('activo');
    if (panelOverlay) panelOverlay.classList.add('activo');
    document.body.style.overflow = 'hidden';
  }
  function closePanels() {
    if (panelFiltrar) panelFiltrar.classList.remove('activo');
    if (panelOrdenar) panelOrdenar.classList.remove('activo');
    if (panelOverlay) panelOverlay.classList.remove('activo');
    document.body.style.overflow = '';
  }
  if (botonFilter && panelFiltrar) {
    botonFilter.addEventListener('click', function () {
      return togglePanel(panelFiltrar);
    });
  }
  if (botonOrdenar && panelOrdenar) {
    botonOrdenar.addEventListener('click', function () {
      return togglePanel(panelOrdenar);
    });
  }
  if (panelOverlay) {
    panelOverlay.addEventListener('click', closePanels);
  }
  if (closeFilter) closeFilter.addEventListener('click', closePanels);
  if (closeSort) closeSort.addEventListener('click', closePanels);
  var precioMinInput = document.getElementById('precioMin');
  var precioMaxInput = document.getElementById('precioMax');
  var precioMinValor = document.getElementById('precioMinValor');
  var precioMaxValor = document.getElementById('precioMaxValor');
  if (precioMinInput && precioMaxInput && precioMinValor && precioMaxValor) {
    var updatePriceValues = function updatePriceValues(e) {
      var minVal = parseInt(precioMinInput.value);
      var maxVal = parseInt(precioMaxInput.value);
      if (minVal > maxVal) {
        if (e && e.target === precioMinInput) {
          precioMaxInput.value = minVal;
          maxVal = minVal;
        } else if (e && e.target === precioMaxInput) {
          precioMinInput.value = maxVal;
          minVal = maxVal;
        }
      }
      precioMinValor.textContent = minVal;
      precioMaxValor.textContent = maxVal;
    };
    precioMinInput.addEventListener('input', function (e) {
      updatePriceValues(e);
    });
    precioMaxInput.addEventListener('input', function (e) {
      updatePriceValues(e);
    });

    // Asegurar que el que se toca se pone encima inmediatamente
    var handlePointer = function handlePointer(e) {
      e.target.style.zIndex = "3";
      (e.target === precioMinInput ? precioMaxInput : precioMinInput).style.zIndex = "2";
    };
    precioMinInput.addEventListener('pointerdown', handlePointer);
    precioMaxInput.addEventListener('pointerdown', handlePointer);

    // Inicialización
    updatePriceValues();
  }
  var sortOptions = document.querySelectorAll('.sort-option');
  var ordenInput = document.getElementById('ordenInput');
  var filterSortForm = document.getElementById('filterSortForm');
  if (sortOptions.length > 0 && ordenInput && filterSortForm) {
    sortOptions.forEach(function (button) {
      button.addEventListener('click', function () {
        ordenInput.value = this.dataset.sortValue;
        filterSortForm.submit();
      });
    });
  }
  var dropdowns = document.querySelectorAll('.dropdown-custom');
  dropdowns.forEach(function (dropdown) {
    var header = dropdown.querySelector('.dropdown-header');
    header.addEventListener('click', function () {
      dropdowns.forEach(function (other) {
        if (other !== dropdown) other.classList.remove('open');
      });
      dropdown.classList.toggle('open');
    });
  });
}

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ var __webpack_exports__ = (__webpack_exec__("./resources/js/pages/joyas-index.js"));
/******/ }
]);
//# sourceMappingURL=joyas-index.js.map