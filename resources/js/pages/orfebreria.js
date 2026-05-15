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
    const formulario = document.getElementById('form-reservar-cita');

    if (!formulario) return;

    formulario.addEventListener('submit', function (event) {
        // Validación básica
        const fecha = formulario.querySelector('#fecha-cita').value;
        const hora = formulario.querySelector('#hora-cita').value;

        if (!fecha || !hora) {
            event.preventDefault();
            mostrarError('Por favor, completa la fecha y la hora de la cita.');
            return;
        }

        // Validar que la fecha no sea anterior a hoy
        const fechaSeleccionada = new Date(fecha + 'T' + hora);
        const ahora = new Date();

        if (fechaSeleccionada < ahora) {
            event.preventDefault();
            mostrarError('La fecha y hora de la cita no pueden ser anteriores al momento actual.');
            return;
        }

        const botonSubmit = formulario.querySelector('.btn-confirmar-cita');
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
    const errorAnterior = document.querySelector('.error-temporal');
    if (errorAnterior) errorAnterior.remove();

    const divError = document.createElement('div');
    divError.className = 'error-temporal';
    divError.style.cssText = `
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.3);
        color: #dc3545;
        padding: 1rem;
        border-radius: 4px;
        margin-bottom: 1.5rem;
        font-family: 'Lato', sans-serif;
        text-align: center;
        animation: fadeInUp 0.3s ease;
    `;
    divError.textContent = mensaje;

    const formulario = document.getElementById('form-reservar-cita');
    formulario.insertBefore(divError, formulario.firstChild);

    // Auto-eliminar después de 4 segundos
    setTimeout(() => {
        if (divError.parentNode) {
            divError.style.opacity = '0';
            divError.style.transition = 'opacity 0.3s ease';
            setTimeout(() => divError.remove(), 300);
        }
    }, 4000);
}

/**
 * Establece la fecha mínima como hoy
 */
function initFechaMinima() {
    const inputFecha = document.getElementById('fecha-cita');
    if (!inputFecha) return;

    const hoy = new Date().toISOString().split('T')[0];
    inputFecha.setAttribute('min', hoy);
}

/**
 * Lazy loading de imágenes específico para la página de orfebrería
 */
function initLazyLoadingOrfebreria() {
    if (!('IntersectionObserver' in window)) {
        document.querySelectorAll('img[data-src]').forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
        return;
    }

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
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

    document.querySelectorAll('.orfebre-imagen img[data-src], .img-informativa[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}
