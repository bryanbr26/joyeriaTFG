<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel de administración') - Joyas Pérez</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:wght@300..800&family=Italiana&display=swap" rel="stylesheet">
    <style>
        .admin-body { min-height: 100vh; margin: 0; background: #f4f6f8; color: #1f2933; font-family: 'Funnel Sans', sans-serif; }
        .admin-shell { display: grid; grid-template-columns: 280px minmax(0, 1fr); min-height: 100vh; }
        .admin-sidebar { position: sticky; top: 0; height: 100vh; display: flex; flex-direction: column; gap: 24px; padding: 28px 20px; background: #111827; color: #fff; }
        .admin-brand { display: flex; flex-direction: column; gap: 4px; color: #fff; text-decoration: none; }
        .admin-brand span { font-family: 'Italiana', serif; font-size: 1.75rem; }
        .admin-brand small, .admin-user a { color: #a7b0bd; }
        .admin-nav { display: flex; flex-direction: column; gap: 8px; }
        .admin-nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 8px; color: #cbd5e1; text-decoration: none; }
        .admin-nav-link:hover, .admin-nav-link.active { background: #263244; color: #fff; }
        .admin-user { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,.12); display: flex; flex-direction: column; gap: 4px; }
        .admin-user a { text-decoration: none; font-size: .9rem; }
        .admin-logout-button { padding: 0; border: 0; background: transparent; color: #a7b0bd; font-size: .9rem; }
        .admin-logout-button:hover { color: #fff; }
        .admin-main { min-width: 0; padding: 32px; }
        .admin-page-header, .admin-panel-header, .admin-stock-item { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .admin-page-header { margin-bottom: 28px; }
        .admin-eyebrow { margin: 0 0 4px; color: #6b7280; font-weight: 700; text-transform: uppercase; font-size: .78rem; }
        .admin-page-header h1 { margin: 0; font-size: 2rem; font-weight: 800; }
        .admin-stat-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; margin-bottom: 24px; }
        .admin-stat-card, .admin-panel { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 8px 24px rgba(17,24,39,.06); }
        .admin-stat-card { padding: 20px; }
        .admin-stat-card span, .admin-stat-card small { color: #6b7280; }
        .admin-stat-card strong { display: block; margin: 8px 0 4px; font-size: 2rem; line-height: 1; }
        .admin-panel-grid { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(320px, .65fr); gap: 20px; }
        .admin-panel { padding: 20px; }
        .admin-panel-header { margin-bottom: 14px; }
        .admin-panel-header h2 { margin: 0; font-size: 1.2rem; font-weight: 800; }
        .admin-panel-header a { color: #111827; font-weight: 700; text-decoration: none; }
        .admin-table { margin-bottom: 0; }
        .admin-stock-list { display: flex; flex-direction: column; gap: 12px; }
        .admin-stock-item { padding: 12px 0; border-bottom: 1px solid #eef0f3; }
        .admin-stock-item:last-child { border-bottom: 0; }
        .admin-stock-item strong, .admin-stock-item span { display: block; }
        .admin-stock-item div span { color: #6b7280; font-size: .9rem; }
        .admin-product-thumb { width: 56px; height: 56px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb; background: #fff; }
        .admin-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .admin-filter-bar { display: grid; grid-template-columns: minmax(220px, 1fr) 180px 140px auto; gap: 12px; margin-bottom: 18px; }
        .admin-form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .admin-form-grid .full { grid-column: 1 / -1; }
        @media (max-width: 992px) { .admin-shell, .admin-stat-grid, .admin-panel-grid, .admin-form-grid, .admin-filter-bar { grid-template-columns: 1fr; } .admin-sidebar { position: static; height: auto; } }
        @media (max-width: 576px) { .admin-main { padding: 20px; } .admin-page-header { align-items: flex-start; flex-direction: column; } }
    </style>
</head>

<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                <span>JOYAS PÉREZ</span>
                <small>Administración</small>
            </a>

            <nav class="admin-nav" aria-label="Panel de administración">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.usuarios.index') }}" class="admin-nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Usuarios</span>
                </a>
                <a href="{{ route('admin.productos.index') }}" class="admin-nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <i class="bi bi-gem"></i>
                    <span>Productos</span>
                </a>
                <a href="{{ route('admin.pedidos.index') }}" class="admin-nav-link {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i>
                    <span>Pedidos</span>
                </a>
                <a href="{{ route('index') }}" class="admin-nav-link">
                    <i class="bi bi-shop"></i>
                    <span>Ver tienda</span>
                </a>
            </nav>

            <div class="admin-user">
                <span>{{ auth()->user()->nombre ?? 'Admin' }}</span>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('¿Quieres cerrar sesión?');">
                    @csrf
                    <button type="submit" class="admin-logout-button">Cerrar sesión</button>
                </form>
            </div>
        </aside>

        <main class="admin-main">
            @yield('content')
        </main>
    </div>
</body>

</html>
