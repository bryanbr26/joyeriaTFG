if (document.getElementById('page-joyas')) {
    initJoyasIndex();
}

function initJoyasIndex() {
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


    const precioMinInput = document.getElementById('precioMin');
    const precioMaxInput = document.getElementById('precioMax');
    const precioMinValor = document.getElementById('precioMinValor');
    const precioMaxValor = document.getElementById('precioMaxValor');

    if (precioMinInput && precioMaxInput && precioMinValor && precioMaxValor) {
        function updatePriceValues(e) {
            let minVal = parseInt(precioMinInput.value);
            let maxVal = parseInt(precioMaxInput.value);

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
        }

        precioMinInput.addEventListener('input', (e) => {
            updatePriceValues(e);
        });

        precioMaxInput.addEventListener('input', (e) => {
            updatePriceValues(e);
        });

        // Asegurar que el que se toca se pone encima inmediatamente
        const handlePointer = (e) => {
            e.target.style.zIndex = "3";
            (e.target === precioMinInput ? precioMaxInput : precioMinInput).style.zIndex = "2";
        };

        precioMinInput.addEventListener('pointerdown', handlePointer);
        precioMaxInput.addEventListener('pointerdown', handlePointer);

        // Inicialización
        updatePriceValues();
    }

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

    const dropdowns = document.querySelectorAll('.dropdown-custom');
    dropdowns.forEach(dropdown => {
        const header = dropdown.querySelector('.dropdown-header');
        header.addEventListener('click', () => {

            dropdowns.forEach(other => {
                if (other !== dropdown) other.classList.remove('open');
            });
            dropdown.classList.toggle('open');
        });
    });
}
