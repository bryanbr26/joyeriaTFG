export function initBuscador() {
    const botonBuscador = document.getElementById('boton-buscador');
    const overlayBuscador = document.getElementById('overlay-buscador');
    const cerrarBuscador = document.getElementById('cerrar-buscador');
    const inputBuscador = document.getElementById('buscador');
    const gridProductos = document.getElementById('grid-productos-buscador');
    const sinResultados = document.getElementById('sin-resultados-buscador');

    // Abrir overlay
    if (botonBuscador) {
        botonBuscador.addEventListener('click', function (e) {
            e.preventDefault();
            overlayBuscador.classList.add('active');
            document.body.style.overflow = 'hidden'; // Evita scroll del body

            setTimeout(() => {
                if (inputBuscador) inputBuscador.focus();
            }, 300);
        });
    }

    // Cerrar overlay
    function cerrarOverlay() {
        overlayBuscador.classList.remove('active');
        document.body.style.overflow = ''; // Restaurar scroll
        if (inputBuscador) {
            inputBuscador.value = '';
        }
        if (gridProductos) {
            gridProductos.innerHTML = '';
        }
        if (sinResultados) {
            sinResultados.style.display = 'none';
        }
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

    // Búsqueda AJAX con debounce
    if (inputBuscador && gridProductos) {
        let timeout = null;
        const baseUrl = gridProductos.dataset.baseUrl || '';

        inputBuscador.addEventListener('input', function () {
            const query = this.value.trim();

            if (timeout) clearTimeout(timeout);

            if (query.length < 2) {
                gridProductos.innerHTML = '';
                if (sinResultados) sinResultados.style.display = 'none';
                return;
            }

            timeout = setTimeout(() => {
                fetch(`/buscar-productos?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error en la búsqueda');
                    return response.json();
                })
                .then(productos => {
                    gridProductos.innerHTML = '';

                    if (!productos || productos.length === 0) {
                        if (sinResultados) sinResultados.style.display = 'block';
                        return;
                    }

                    if (sinResultados) sinResultados.style.display = 'none';

                    productos.forEach(producto => {
                        const card = crearProductoCard(producto, baseUrl);
                        gridProductos.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error('Error buscando productos:', error);
                    gridProductos.innerHTML = '';
                    if (sinResultados) sinResultados.style.display = 'none';
                });
            }, 300);
        });
    }

    function crearProductoCard(producto, baseUrl) {
        const item = document.createElement('div');
        item.className = 'producto-item-buscador';

        const link = document.createElement('a');
        link.href = `${baseUrl}/${producto.categoria}/${producto.id}`;
        link.className = 'producto-enlace';

        const card = document.createElement('div');
        card.className = 'producto-card producto-card-buscador';

        if (producto.ruta_grabado) {
            const img = document.createElement('img');
            img.src = producto.placeholder_url;
            img.dataset.src = producto.imagen_url;
            img.loading = 'lazy';
            img.decoding = 'async';
            img.className = 'lazy-image blur-up producto-imagen';
            img.alt = producto.nombre;
            card.appendChild(img);
        } else {
            const placeholder = document.createElement('div');
            placeholder.className = 'producto-imagen--placeholder';
            placeholder.innerHTML = '<i class="bi bi-gem icono-placeholder"></i>';
            card.appendChild(placeholder);
        }

        const info = document.createElement('div');
        info.className = 'producto-info';

        const titulo = document.createElement('h4');
        titulo.className = 'producto-titulo';
        titulo.textContent = producto.nombre.length > 28 ? producto.nombre.substring(0, 28) + '...' : producto.nombre;

        const marca = document.createElement('p');
        marca.className = 'producto-marca';
        marca.textContent = producto.marca || '';

        const descripcion = document.createElement('p');
        descripcion.className = 'producto-descripcion';
        const desc = producto.descripcion || '';
        descripcion.textContent = desc.length > 35 ? desc.substring(0, 35) + '...' : desc;

        const precio = document.createElement('p');
        precio.className = 'producto-precio';
        precio.textContent = parseFloat(producto.precio).toFixed(2) + ' €';

        info.appendChild(titulo);
        info.appendChild(marca);
        info.appendChild(descripcion);
        info.appendChild(precio);

        card.appendChild(info);
        link.appendChild(card);
        item.appendChild(link);

        return item;
    }
}
