import { initMegaMenu } from './components/mega-menu.js';
import { initBuscador } from './components/buscador.js';
import { initNavbar } from './components/navbar.js';
import { initHomeCarousel } from './pages/home.js';
import { initJoyasIndex } from './pages/joyas-index.js';
import { initProductosShow } from './pages/show.js';

document.addEventListener('DOMContentLoaded', function () {
    // Inicializar componentes globales
    initMegaMenu();
    initBuscador();
    initNavbar();

    // Inicializar scripts de páginas específicas
    initHomeCarousel();
    initJoyasIndex();
    initProductosShow();
});