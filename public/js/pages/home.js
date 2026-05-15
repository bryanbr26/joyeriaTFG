(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/pages/home"],{

/***/ "./resources/js/pages/home.js":
/*!************************************!*\
  !*** ./resources/js/pages/home.js ***!
  \************************************/
/***/ (() => {

if (document.querySelector('.carrusel-joyas')) {
  initHomeCarousel();
}
function initHomeCarousel() {
  var carrusel = document.querySelector('.carrusel-joyas');
  if (!carrusel) return;
  var originalChildren = Array.from(carrusel.children);

  // Duplicar elementos para el efecto de scroll infinito
  originalChildren.forEach(function (child) {
    var clone = child.cloneNode(true);
    carrusel.appendChild(clone);
  });
  var tarjetas = carrusel.querySelectorAll('.tarjeta');
  var isDown = false;
  var startX;
  var scrollLeft;
  var currentSpeed = 0.6;
  var baseSpeed = 0.6;
  var hoverCount = 0; // Contador para manejar múltiples tarjetas en hover
  var isDragging = false;
  var rafId = null;

  // Detectar si es pantalla pequeña (menor a 992px)
  var isMobileOrTablet = window.matchMedia('(max-width: 991px)').matches;
  function checkBoundary() {
    var firstCard = originalChildren[0];
    var gap = parseFloat(getComputedStyle(carrusel).gap) || 0;
    var originalWidth = (firstCard.offsetWidth + gap) * originalChildren.length;
    if (carrusel.scrollLeft >= originalWidth) {
      carrusel.scrollLeft -= originalWidth;
    } else if (carrusel.scrollLeft <= 0) {
      carrusel.scrollLeft += originalWidth;
    }
  }
  function autoScroll() {
    // No auto-scroll en móvil/tablet para ahorrar batería y mejorar rendimiento
    if (isMobileOrTablet) return;
    var targetSpeed = hoverCount > 0 || isDown ? 0 : baseSpeed;

    // Interpolación suave de velocidad
    currentSpeed += (targetSpeed - currentSpeed) * 0.08;

    // Si la velocidad es muy baja y estamos en hover/drag, la forzamos a 0
    if (hoverCount > 0 || isDown) {
      if (Math.abs(currentSpeed) < 0.005) {
        currentSpeed = 0;
      }
    }
    if (Math.abs(currentSpeed) > 0.001) {
      carrusel.scrollLeft += currentSpeed;
      checkBoundary();
    }
    rafId = requestAnimationFrame(autoScroll);
  }

  // Eventos del ratón para arrastrar
  carrusel.addEventListener('mousedown', function (e) {
    isDown = true;
    isDragging = false;
    carrusel.classList.add('dragging');
    startX = e.pageX - carrusel.offsetLeft;
    scrollLeft = carrusel.scrollLeft;
  });
  carrusel.addEventListener('mouseleave', function () {
    if (isDown) {
      isDown = false;
      isDragging = false;
      carrusel.classList.remove('dragging');
    }
  });
  carrusel.addEventListener('mouseup', function () {
    isDown = false;
    carrusel.classList.remove('dragging');
    setTimeout(function () {
      isDragging = false;
    }, 50);
  });
  carrusel.addEventListener('mousemove', function (e) {
    if (!isDown) return;
    e.preventDefault();
    isDragging = true;
    var x = e.pageX - carrusel.offsetLeft;
    var walk = (x - startX) * 1.5;
    carrusel.scrollLeft = scrollLeft - walk;
    checkBoundary();
  });

  // Pausa suave al pasar el ratón sobre cada tarjeta individual
  tarjetas.forEach(function (tarjeta) {
    tarjeta.addEventListener('mouseenter', function () {
      hoverCount++;
    });
    tarjeta.addEventListener('mouseleave', function () {
      hoverCount = Math.max(0, hoverCount - 1);
    });
  });

  // Eventos táctiles para móviles
  carrusel.addEventListener('touchstart', function (e) {
    isDown = true;
    startX = e.touches[0].pageX - carrusel.offsetLeft;
    scrollLeft = carrusel.scrollLeft;
  }, {
    passive: true
  });
  carrusel.addEventListener('touchend', function () {
    isDown = false;
  });
  carrusel.addEventListener('touchmove', function (e) {
    if (!isDown) return;
    var x = e.touches[0].pageX - carrusel.offsetLeft;
    var walk = (x - startX) * 2;
    carrusel.scrollLeft = scrollLeft - walk;
    checkBoundary();
  }, {
    passive: true
  });

  // Interceptar clics en el carrusel si estábamos arrastrando
  carrusel.addEventListener('click', function (e) {
    if (isDragging) {
      e.preventDefault();
      e.stopPropagation();
    }
  }, true);

  // Iniciar scroll automático
  rafId = requestAnimationFrame(autoScroll);
}

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["css/app"], () => (__webpack_exec__("./resources/js/pages/home.js"), __webpack_exec__("./resources/sass/app.scss")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=home.js.map