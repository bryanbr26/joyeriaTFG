/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_mega_menu_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/mega-menu.js */ "./resources/js/components/mega-menu.js");
/* harmony import */ var _components_buscador_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/buscador.js */ "./resources/js/components/buscador.js");
/* harmony import */ var _components_navbar_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/navbar.js */ "./resources/js/components/navbar.js");
/* harmony import */ var _pages_home_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./pages/home.js */ "./resources/js/pages/home.js");
/* harmony import */ var _pages_joyas_index_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./pages/joyas-index.js */ "./resources/js/pages/joyas-index.js");





document.addEventListener('DOMContentLoaded', function () {
  // Inicializar componentes globales
  (0,_components_mega_menu_js__WEBPACK_IMPORTED_MODULE_0__.initMegaMenu)();
  (0,_components_buscador_js__WEBPACK_IMPORTED_MODULE_1__.initBuscador)();
  (0,_components_navbar_js__WEBPACK_IMPORTED_MODULE_2__.initNavbar)();

  // Inicializar scripts de páginas específicas
  (0,_pages_home_js__WEBPACK_IMPORTED_MODULE_3__.initHomeCarousel)();
  (0,_pages_joyas_index_js__WEBPACK_IMPORTED_MODULE_4__.initJoyasIndex)();
});

/***/ }),

/***/ "./resources/js/components/buscador.js":
/*!*********************************************!*\
  !*** ./resources/js/components/buscador.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initBuscador: () => (/* binding */ initBuscador)
/* harmony export */ });
function initBuscador() {
  var botonBuscador = document.getElementById('boton-buscador');
  var overlayBuscador = document.getElementById('overlay-buscador');
  var cerrarBuscador = document.getElementById('cerrar-buscador');

  // Abrir overlay
  if (botonBuscador) {
    botonBuscador.addEventListener('click', function (e) {
      e.preventDefault();
      overlayBuscador.classList.add('active');
      document.body.style.overflow = 'hidden'; // Evita scroll del body

      // Opcional: Enfocar el input
      setTimeout(function () {
        var input = document.getElementById('buscador');
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

/***/ }),

/***/ "./resources/js/components/mega-menu.js":
/*!**********************************************!*\
  !*** ./resources/js/components/mega-menu.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initMegaMenu: () => (/* binding */ initMegaMenu)
/* harmony export */ });
function initMegaMenu() {
  // Elementos del mega menú
  var categoriasItems = document.querySelectorAll('.categoria-item');
  var imagenElemento = document.querySelector('.img-drop-down img');
  var textoElemento = document.querySelector('.imagen-texto');

  // Imagen por defecto
  var imagenDefault = {
    url: '/images/joyas/default.jpg',
    texto: 'Descubre nuestra colección exclusiva'
  };

  // Función para cambiar imagen con fade
  function cambiarImagen(nuevaUrl, nuevoTexto) {
    if (!imagenElemento) return;

    // Efecto fade out
    imagenElemento.style.opacity = '0';
    setTimeout(function () {
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
    categoriasItems.forEach(function (item) {
      item.addEventListener('mouseenter', function () {
        var _this$querySelector;
        var imagenUrl = this.getAttribute('data-imagen');
        var texto = ((_this$querySelector = this.querySelector('a')) === null || _this$querySelector === void 0 ? void 0 : _this$querySelector.textContent) || 'Categoría';
        if (imagenUrl) {
          cambiarImagen(imagenUrl, "Explora nuestra colecci\xF3n de ".concat(texto.toLowerCase()));
        }
      });
    });

    // Resetear cuando el mouse sale del menú
    var dropdownMenu = document.querySelector('.dropdown-menu');
    if (dropdownMenu) {
      dropdownMenu.addEventListener('mouseleave', function () {
        resetearImagen();
      });
    }
  }
}

/***/ }),

/***/ "./resources/js/components/navbar.js":
/*!*******************************************!*\
  !*** ./resources/js/components/navbar.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initNavbar: () => (/* binding */ initNavbar)
/* harmony export */ });
function initNavbar() {
  // Mostrar Nav al hacer scroll pasado el header-icon
  var headerIconContainer = document.getElementById('header-icon');
  var mainNavBar = document.getElementById('nav-bar');
  if (headerIconContainer && mainNavBar) {
    var checkScrollForNav = function checkScrollForNav() {
      // Umbral = la parte inferior de header-icon respecto al inicio del documento
      var threshold = headerIconContainer.offsetTop + headerIconContainer.offsetHeight;

      // Si hemos scrolleado más allá de ese punto, mostramos el nav (fixed al top)
      if (window.scrollY > threshold) {
        mainNavBar.classList.add('mostrar-nav');
      } else {
        mainNavBar.classList.remove('mostrar-nav');
      }
    }; // Escuchar evento de scroll
    // Si no es la página principal, hacemos que el nav sea visible por defecto al inicio
    var isHomePage = document.body.classList.contains('home-page');
    if (!isHomePage) {
      mainNavBar.classList.add('nav-visible-defecto');
    }
    window.addEventListener('scroll', checkScrollForNav);
    // Llamar una vez por si se recargó la página con scroll
    checkScrollForNav();
  }
}

/***/ }),

/***/ "./resources/js/pages/home.js":
/*!************************************!*\
  !*** ./resources/js/pages/home.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initHomeCarousel: () => (/* binding */ initHomeCarousel)
/* harmony export */ });
function initHomeCarousel() {
  var carrusel = document.querySelector('.carrusel-joyas');
  if (!carrusel) return;
  var originalChildren = Array.from(carrusel.children);

  // Duplicar elementos para el efecto de scroll infinito
  originalChildren.forEach(function (child) {
    var clone = child.cloneNode(true);
    carrusel.appendChild(clone);
  });
  var isDown = false;
  var startX;
  var scrollLeft;
  var autoScrollInterval;
  var speed = 0.6; // Velocidad del auto scroll

  function startAutoScroll() {
    autoScrollInterval = requestAnimationFrame(autoScroll);
  }
  function stopAutoScroll() {
    cancelAnimationFrame(autoScrollInterval);
  }
  function checkBoundary() {
    var firstCard = originalChildren[0];
    var gap = parseFloat(getComputedStyle(carrusel).gap) || 0;
    // Ancho total del set original de tarjetas (incluyendo su gap correspondiente)
    var originalWidth = (firstCard.offsetWidth + gap) * originalChildren.length;
    if (carrusel.scrollLeft >= originalWidth) {
      // Si se hace scroll más allá del primer set, se reinicia al principio sin salto visual
      carrusel.scrollLeft -= originalWidth;
    } else if (carrusel.scrollLeft <= 0) {
      // Si se hace scroll hacia atrás más allá de 0, salta al set clonado
      carrusel.scrollLeft += originalWidth;
    }
  }
  function autoScroll() {
    if (!isDown) {
      carrusel.scrollLeft += speed;
      checkBoundary();
    }
    autoScrollInterval = requestAnimationFrame(autoScroll);
  }

  // Eventos del ratón para arrastrar
  carrusel.addEventListener('mousedown', function (e) {
    isDown = true;
    carrusel.classList.add('dragging');
    startX = e.pageX - carrusel.offsetLeft;
    scrollLeft = carrusel.scrollLeft;
    stopAutoScroll();
  });
  carrusel.addEventListener('mouseleave', function () {
    if (isDown) {
      isDown = false;
      carrusel.classList.remove('dragging');
      startAutoScroll();
    }
  });
  carrusel.addEventListener('mouseup', function () {
    isDown = false;
    carrusel.classList.remove('dragging');
    startAutoScroll();
  });
  carrusel.addEventListener('mousemove', function (e) {
    if (!isDown) return;
    e.preventDefault();
    var x = e.pageX - carrusel.offsetLeft;
    var walk = (x - startX) * 1.5; // Multiplicador de velocidad de arrastre
    carrusel.scrollLeft = scrollLeft - walk;
    checkBoundary();
  });

  // Eventos táctiles para móviles
  carrusel.addEventListener('touchstart', function (e) {
    isDown = true;
    startX = e.touches[0].pageX - carrusel.offsetLeft;
    scrollLeft = carrusel.scrollLeft;
    stopAutoScroll();
  });
  carrusel.addEventListener('touchend', function () {
    isDown = false;
    startAutoScroll();
  });
  carrusel.addEventListener('touchmove', function (e) {
    if (!isDown) return;
    var x = e.touches[0].pageX - carrusel.offsetLeft;
    var walk = (x - startX) * 2;
    carrusel.scrollLeft = scrollLeft - walk;
    checkBoundary();
  });

  // Iniciar scroll automático
  startAutoScroll();
}

/***/ }),

/***/ "./resources/js/pages/joyas-index.js":
/*!*******************************************!*\
  !*** ./resources/js/pages/joyas-index.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initJoyasIndex: () => (/* binding */ initJoyasIndex)
/* harmony export */ });
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

  // Doble slider de precio
  var precioMinInput = document.getElementById('precioMin');
  var precioMaxInput = document.getElementById('precioMax');
  var precioMinValor = document.getElementById('precioMinValor');
  var precioMaxValor = document.getElementById('precioMaxValor');
  if (precioMinInput && precioMaxInput && precioMinValor && precioMaxValor) {
    var updatePriceValues = function updatePriceValues() {
      var minVal = parseInt(precioMinInput.value);
      var maxVal = parseInt(precioMaxInput.value);
      if (minVal > maxVal) {
        // Cambia los valores si se pasa el min al max
        if (this === precioMinInput) {
          precioMaxInput.value = minVal;
          maxVal = minVal;
        } else {
          precioMinInput.value = maxVal;
          minVal = maxVal;
        }
      }
      precioMinValor.textContent = minVal;
      precioMaxValor.textContent = maxVal;
    };
    precioMinInput.addEventListener('input', updatePriceValues);
    precioMaxInput.addEventListener('input', updatePriceValues);

    // Inicializamos los valores
    updatePriceValues();
  }

  // Ordenar
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
}

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=app.js.map