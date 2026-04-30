<header class="border-bottom">

    <div class="container-fluid d-flex flex-row justify-content-center align-items-center py-2 bg-white">
        <div class="LogoLetra">
            <a href="{{ route('index') }}">
                JOYAS PÉREZ
            </a>
        </div>
    </div>

    <!-- Fila 2: Buscador e Iconos -->
    <div class="container-fluid py-2 bg-white" id="header">

        <!-- Buscador -->
        <div class="col" id="contenedor-buscador">
            <div class="d-flex justify-content-center">
                <div class="input-group bg-grey" style="max-width: 565px;" id="contenedor-input-buscador">
                    <input type="text" class="form-control border-dark bg-grey" placeholder="BUSCAR" id="buscador">
                </div>
            </div>
        </div>

        <!-- Iconos -->
        <div class="col-auto" id="contenedor-iconos">
            <div class="d-flex gap-3">
                <a href="{{ route('login') }}" class="text-dark" title="Gestión Usuarios">
                    <i class="bi bi-person fs-5"></i>
                </a>
                <a href="#" class="text-dark" title="ubicacion">
                    <i class="bi bi-geo-alt"></i>
                </a>
                <a href="#" class="text-dark" title="Favoritos">
                    <i class="bi bi-heart fs-5"></i>
                </a>
                <a href="#" class="text-dark position-relative" title="Carrito">
                    <i class="bi bi-bag fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                        0
                    </span>
                </a>
            </div>
        </div>

    </div>

    <!-- Navegación con Mega Menú -->
    <nav class="border-top navbar-light" id="nav-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <ul class="nav justify-content-center py-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button">
                                Joyería
                            </a>

                            <!-- Mega Menú -->
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <!-- Columna Izquierda: Lista de categorías -->
                                <div class="titulo-contenedor">
                                    <h3>JOYERIA</h3>
                                </div>
                                <div class="lista-joyas-container">
                                    <ul class="lista-joyas">
                                        <li class="categoria-item"
                                            data-imagen="{{ asset('images/joyas/collares.jpg') }}">
                                            <a href="{{ route('joyas.index', 'collares') }}">Collares</a>
                                        </li>
                                        <li class="categoria-item"
                                            data-imagen="{{ asset('images/joyas/anillos.jpg') }}">
                                            <a href="{{ route('joyas.index', 'anillos') }}">Anillos</a>
                                        </li>
                                        <li class="categoria-item"
                                            data-imagen="{{ asset('images/joyas/pulseras.jpg') }}">
                                            <a href="{{ route('joyas.index', 'pulseras') }}">Pulseras</a>
                                        </li>
                                        <li class="categoria-item"
                                            data-imagen="{{ asset('images/joyas/pendientes.jpg') }}">
                                            <a href="{{ route('joyas.index', 'pendientes') }}">Pendientes</a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Columna Derecha: Imagen dinámica -->
                                <div class="img-drop-down">
                                    <img id="categoria-imagen" src="{{ asset('images/joyas/default.jpg') }}"
                                        alt="Categoría destacada">
                                    <div class="imagen-texto">Pasa el mouse sobre una categoría</div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('regalos') }}">Regalos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('personaliza') }}">Personaliza tus joyas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('comproOro') }}">Compro Oro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('orfebreria') }}">Orfebrería</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('historia') }}">Historia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('contacto') }}">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>