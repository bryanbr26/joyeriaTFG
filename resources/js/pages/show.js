import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

if (document.getElementById('producto-show')) {
    initProductosShow();
}

function initProductosShow() {
    const imagenCol = document.querySelector('.producto-detalle-imagen');
    const infoCol = document.querySelector('.producto-info');

    if (!imagenCol || !infoCol) return;

    // Solo activar en escritorio (>= 768px)
    const mediaQuery = window.matchMedia('(min-width: 768px)');

    let scrollTriggerInstance = null;

    function crearScrollTrigger() {
        if (scrollTriggerInstance) return; // Ya está creado

        scrollTriggerInstance = ScrollTrigger.create({
            trigger: '.producto-detalle-grid',
            start: 'top top',
            end: () => `+=${imagenCol.offsetHeight - infoCol.offsetHeight}`,
            pin: infoCol,
            pinSpacing: false,
            anticipatePin: 1,
            invalidateOnRefresh: true,
        });
    }

    function destruirScrollTrigger() {
        if (scrollTriggerInstance) {
            scrollTriggerInstance.kill();
            scrollTriggerInstance = null;
        }
    }

    // Evaluar al cargar
    function evaluarMediaQuery(e) {
        if (e.matches) {
            crearScrollTrigger();
        } else {
            destruirScrollTrigger();
        }
    }

    // Escuchar cambios de tamaño de pantalla
    mediaQuery.addEventListener('change', evaluarMediaQuery);

    // Refrescar ScrollTrigger cuando se despliegan las descripciones informativas
    // para recalcular la altura de la columna y el punto de pin
    document.querySelectorAll('.dropdown-custom .dropdown-header').forEach(header => {
        header.addEventListener('click', () => {
            // Esperar un poco a que la transición de CSS termine (0.3s en SCSS)
            setTimeout(() => {
                ScrollTrigger.refresh();
            }, 400);
        });
    });

    // Ejecutar al inicio
    evaluarMediaQuery(mediaQuery);

    const imagenPrincipal = document.getElementById('producto-imagen-principal');
    const miniaturas = document.querySelectorAll('.producto-miniatura');

    miniaturas.forEach(miniatura => {
        miniatura.addEventListener('click', function () {
            if (!imagenPrincipal) return;

            imagenPrincipal.src = this.dataset.fullSrc;
            miniaturas.forEach(img => img.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // ==========================================
    // Botón añadir a la cesta (Usuario Autenticado)
    // ==========================================
    const btnCestaAuth = document.getElementById('btnAnadirCestaAuth');
    if (btnCestaAuth) {
        btnCestaAuth.addEventListener('click', function () {
            const url = this.dataset.url;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Deshabilitar botón temporalmente para evitar doble click
            this.disabled = true;
            const originalHTML = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Añadiendo...';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    this.disabled = false;
                    this.innerHTML = originalHTML;

                    if (data.success) {
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount && data.totalItems !== undefined) {
                            cartCount.textContent = data.totalItems;
                        }

                        // Update panel html if provided
                        if (data.cartHtml) {
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = data.cartHtml;
                            const newPanel = tempDiv.querySelector('.panel-carrito');
                            if (newPanel) {
                                document.getElementById('panelCarrito').innerHTML = newPanel.innerHTML;
                            }
                        }

                        // Open the panel by dispatching an event
                        document.dispatchEvent(new CustomEvent('openCartPanel'));
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => {
                    this.disabled = false;
                    this.innerHTML = originalHTML;
                    console.error('Error:', err);
                    alert('Hubo un error al añadir a la cesta.');
                });
        });
    }

    // ==========================================
    // Botón favorito (Usuario Autenticado) - AJAX toggle
    // ==========================================
    const btnFav = document.getElementById('btnFavorito');
    if (btnFav) {
        btnFav.addEventListener('click', function () {
            const url = this.dataset.url;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const icon = this.querySelector('i');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.favorito) {
                            // Añadido a favoritos
                            icon.classList.remove('bi-heart');
                            icon.classList.add('bi-heart-fill', 'text-danger');
                        } else {
                            // Eliminado de favoritos
                            icon.classList.remove('bi-heart-fill', 'text-danger');
                            icon.classList.add('bi-heart');
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Hubo un error al actualizar favoritos.');
                });
        });
    }

    // ==========================================
    // Modales de login (abrir/cerrar)
    // ==========================================
    document.querySelectorAll('[data-modal-target]').forEach(trigger => {
        trigger.addEventListener('click', function () {
            const modalId = this.dataset.modalTarget;
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.add('activo');
        });
    });

    document.querySelectorAll('.modal-overlay, [data-modal-close]').forEach(el => {
        el.addEventListener('click', function (e) {
            if (e.target === this || this.dataset.modalClose !== undefined) {
                const modal = this.closest('.modal-overlay') || document.querySelector('.modal-overlay.activo');
                if (modal) modal.classList.remove('activo');
            }
        });
    });
}
