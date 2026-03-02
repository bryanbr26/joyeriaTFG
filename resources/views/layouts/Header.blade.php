<header>

    <!-- Fila 1: Logo centrado -->
    <div class="header-top d-flex justify-content-center align-items-center" style="padding: 1.4rem 1.5rem 1.2rem;">
        <a href="{{ route('index') }}" class="brand-name text-center anim-fade-in-down">
            Joyas Pérez
        </a>
    </div>

    <!-- Fila 2: Buscador + Iconos -->
    <div class="d-flex align-items-center px-4" style="background: linear-gradient(135deg, var(--blue-700) 0%, var(--blue-600) 100%);
                border-top: 1px solid rgba(255,255,255,0.1);
                border-bottom: 1px solid rgba(255,255,255,0.08);
                padding-top: 0.85rem; padding-bottom: 0.85rem;">

        <!-- Buscador -->
        <div class="flex-grow-1 d-flex justify-content-center anim-fade-in anim-delay-1">
            <div class="input-group" style="max-width: 560px;">
                <input type="text" class="form-control search-input" placeholder="Buscar joyas…">
                <button class="btn search-btn" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <!-- Iconos de acción -->
        <div class="d-flex gap-3 align-items-center ms-4 anim-fade-in anim-delay-2">

            <a href="{{ route('usuarios.index') }}" class="header-icon" title="Gestión Usuarios">
                <i class="bi bi-person-circle"></i>
            </a>

            <a href="#" class="header-icon" title="Nuestra tienda">
                <i class="bi bi-geo-alt"></i>
            </a>

            <a href="#" class="header-icon" title="Mis favoritos">
                <i class="bi bi-heart"></i>
            </a>

            <a href="#" class="header-icon position-relative" title="Mi carrito">
                <i class="bi bi-bag"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge badge-cart rounded-pill">
                    0
                </span>
            </a>

        </div>
    </div>

    <!-- Fila 3: Navegación principal -->
    <nav class="main-nav">
        <div class="container-fluid">
            <ul class="nav justify-content-center py-1">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navJoyeria" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Joyería
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navJoyeria">
                        <li><a class="dropdown-item" href="{{ route('joyas.index', 'collares') }}">
                                <i class="bi bi-gem me-2 text-primary"></i>Collares</a></li>
                        <li><a class="dropdown-item" href="{{ route('joyas.index', 'anillos') }}">
                                <i class="bi bi-circle me-2 text-primary"></i>Anillos</a></li>
                        <li><a class="dropdown-item" href="{{ route('joyas.index', 'pulseras') }}">
                                <i class="bi bi-watch me-2 text-primary"></i>Pulseras</a></li>
                        <li><a class="dropdown-item" href="{{ route('joyas.index', 'pendientes') }}">
                                <i class="bi bi-stars me-2 text-primary"></i>Pendientes</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('regalos') }}">Regalos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('personaliza') }}">Personaliza tus joyas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('comproOro') }}">Compro Oro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orfebreria') }}">Orfebrería</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('historia') }}">Historia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contacto') }}">Contacto</a>
                </li>

            </ul>
        </div>
    </nav>

</header>