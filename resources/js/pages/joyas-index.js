export function initJoyasIndex() {
    // Toggles de Paneles
    const botonFilter = document.getElementById('boton-filter');
    const botonOrdenar = document.getElementById('boton-ordenar');
    const panelFiltrar = document.getElementById('panelFiltrar');
    const panelOrdenar = document.getElementById('panelOrdenar');
    const panelOverlay = document.getElementById('panelOverlay');
    const closeFilter = document.getElementById('closeFilter');
    const closeSort = document.getElementById('closeSort');

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
        botonFilter.addEventListener('click', () => togglePanel(panelFiltrar));
    }

    if (botonOrdenar && panelOrdenar) {
        botonOrdenar.addEventListener('click', () => togglePanel(panelOrdenar));
    }

    if (panelOverlay) {
        panelOverlay.addEventListener('click', closePanels);
    }

    if (closeFilter) closeFilter.addEventListener('click', closePanels);
    if (closeSort) closeSort.addEventListener('click', closePanels);

    // Doble slider de precio
    const precioMinInput = document.getElementById('precioMin');
    const precioMaxInput = document.getElementById('precioMax');
    const precioMinValor = document.getElementById('precioMinValor');
    const precioMaxValor = document.getElementById('precioMaxValor');

    if (precioMinInput && precioMaxInput && precioMinValor && precioMaxValor) {
        function updatePriceValues() {
            let minVal = parseInt(precioMinInput.value);
            let maxVal = parseInt(precioMaxInput.value);

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
        }

        precioMinInput.addEventListener('input', updatePriceValues);
        precioMaxInput.addEventListener('input', updatePriceValues);

        // Inicializamos los valores
        updatePriceValues();
    }

    // Ordenar
    const sortOptions = document.querySelectorAll('.sort-option');
    const ordenInput = document.getElementById('ordenInput');
    const filterSortForm = document.getElementById('filterSortForm');

    if (sortOptions.length > 0 && ordenInput && filterSortForm) {
        sortOptions.forEach(button => {
            button.addEventListener('click', function () {
                ordenInput.value = this.dataset.sortValue;
                filterSortForm.submit();
            });
        });
    }
}


