(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/pages/orfebreria"],{

/***/ "./resources/js/pages/orfebreria.js":
/*!******************************************!*\
  !*** ./resources/js/pages/orfebreria.js ***!
  \******************************************/
/***/ (() => {

/**
 * Orfebrería Page Scripts
 * Maneja el formulario de reserva de citas y utilidades de la página
 */

document.addEventListener('DOMContentLoaded', function () {
  initFormularioCita();
  initLazyLoadingOrfebreria();
  initFechaMinima();
});

/**
 * Inicializa el formulario de reserva de cita
 */
function initFormularioCita() {
  var formulario = document.getElementById('form-reservar-cita');
  if (!formulario) return;
  formulario.addEventListener('submit', function (event) {
    // Validación básica
    var fecha = formulario.querySelector('#fecha-cita').value;
    var hora = formulario.querySelector('#hora-cita').value;
    if (!fecha || !hora) {
      event.preventDefault();
      mostrarError('Por favor, completa la fecha y la hora de la cita.');
      return;
    }

    // Validar que la fecha no sea anterior a hoy
    var fechaSeleccionada = new Date(fecha + 'T' + hora);
    var ahora = new Date();
    if (fechaSeleccionada < ahora) {
      event.preventDefault();
      mostrarError('La fecha y hora de la cita no pueden ser anteriores al momento actual.');
      return;
    }
    var botonSubmit = formulario.querySelector('.btn-confirmar-cita');
    botonSubmit.disabled = true;
    botonSubmit.textContent = 'Enviando...';
    botonSubmit.style.opacity = '0.7';
  });
}

/**
 * Muestra un mensaje de error temporal
 */
function mostrarError(mensaje) {
  // Eliminar mensaje anterior si existe
  var errorAnterior = document.querySelector('.error-temporal');
  if (errorAnterior) errorAnterior.remove();
  var divError = document.createElement('div');
  divError.className = 'error-temporal';
  divError.style.cssText = "\n        background: rgba(220, 53, 69, 0.1);\n        border: 1px solid rgba(220, 53, 69, 0.3);\n        color: #dc3545;\n        padding: 1rem;\n        border-radius: 4px;\n        margin-bottom: 1.5rem;\n        font-family: 'Lato', sans-serif;\n        text-align: center;\n        animation: fadeInUp 0.3s ease;\n    ";
  divError.textContent = mensaje;
  var formulario = document.getElementById('form-reservar-cita');
  formulario.insertBefore(divError, formulario.firstChild);

  // Auto-eliminar después de 4 segundos
  setTimeout(function () {
    if (divError.parentNode) {
      divError.style.opacity = '0';
      divError.style.transition = 'opacity 0.3s ease';
      setTimeout(function () {
        return divError.remove();
      }, 300);
    }
  }, 4000);
}

/**
 * Establece la fecha mínima como hoy
 */
function initFechaMinima() {
  var inputFecha = document.getElementById('fecha-cita');
  if (!inputFecha) return;
  var hoy = new Date().toISOString().split('T')[0];
  inputFecha.setAttribute('min', hoy);
}

/**
 * Lazy loading de imágenes específico para la página de orfebrería
 */
function initLazyLoadingOrfebreria() {
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('img[data-src]').forEach(function (img) {
      img.src = img.dataset.src;
      img.removeAttribute('data-src');
    });
    return;
  }
  var imageObserver = new IntersectionObserver(function (entries, observer) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        var img = entry.target;
        if (img.dataset.src) {
          img.src = img.dataset.src;
          img.removeAttribute('data-src');
          img.classList.add('loaded');
        }
        observer.unobserve(img);
      }
    });
  }, {
    rootMargin: '100px 0px',
    threshold: 0.01
  });
  document.querySelectorAll('.orfebre-imagen img[data-src], .img-informativa[data-src]').forEach(function (img) {
    imageObserver.observe(img);
  });
}

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ var __webpack_exports__ = (__webpack_exec__("./resources/js/pages/orfebreria.js"));
/******/ }
]);
//# sourceMappingURL=orfebreria.js.map