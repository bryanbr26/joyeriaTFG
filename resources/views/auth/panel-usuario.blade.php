@extends('layouts.layout')

@section('title', 'Mi Cuenta')
@section('content')

<div class="panel-usuario-bg">
    <div class="container">

        <!-- Header: Bienvenida + Logout -->
        <div class="panel-usuario-header">
        
            <div>
                <h2>Bienvenid{{ auth()->user()->genero === 'hombre' ? 'o' : 'a' }}, {{ auth()->user()->nombre }}</h2>
            </div>
            <div class="panel-usuario-actions">
                @if(auth()->user()->rol === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light">
                        <i class="bi bi-speedometer2 me-2"></i>Ir al panel de admin
                    </a>
                @endif
                <a href="{{ route('logout') }}" class="btn btn-outline-light">
                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                </a>
            </div>
        </div>

        <!-- Grid principal -->
        <div class="panel-usuario-grid">

            <!-- Columna izquierda: Pedidos (60%) -->
            <div class="panel-usuario-card">
                <h3><i class="bi bi-bag-check me-2"></i>Mis Compras</h3>

                @forelse($pedidos as $pedido)
                    <div class="pedido-item">
                        <div class="pedido-header">
                            <div>
                                <h5>Pedido #{{ $pedido->id }}</h5>
                                <div class="pedido-fecha">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : 'Sin fecha' }}
                                </div>
                                @php $claseEstado = 'estado-' . $pedido->estado; @endphp
                                <span class="pedido-estado {{ $claseEstado }}">{{ ucfirst($pedido->estado) }}</span>
                            </div>
                            <div class="pedido-total">{{ number_format($pedido->total, 2) }}€</div>
                        </div>

                        @if($pedido->detalles->count() > 0)
                            <div class="pedido-productos">
                                @foreach($pedido->detalles->take(3) as $detalle)
                                    <div class="pedido-producto">
                                        <span>
                                            {{ $detalle->producto ? $detalle->producto->nombre : 'Producto eliminado' }}
                                            <span class="text-muted">× {{ $detalle->cantidad }}</span>
                                        </span>
                                        <span class="fw-semibold">{{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}€</span>
                                    </div>
                                @endforeach
                                @if($pedido->detalles->count() > 3)
                                    <div class="text-muted small mt-1">y {{ $pedido->detalles->count() - 3 }} más...</div>
                                @endif
                            </div>
                        @endif

                        <div class="pedido-ver-detalles">
                            <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i>Ver detalles
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="sin-pedidos">
                        <i class="bi bi-bag"></i>
                        <h5>Aún no tienes compras</h5>
                        <p>Cuando realices un pedido, aparecerá aquí.</p>
                        <a href="{{ route('index') }}" class="btn btn-dark mt-2">Explorar joyas</a>
                    </div>
                @endforelse
            </div>

            <!-- Columna derecha: Información del usuario (40%) -->
            <div class="panel-usuario-card">
                <h3><i class="bi bi-person-circle me-2"></i>Mi Información</h3>

                <div class="info-usuario-row">
                    <span class="info-usuario-label">Nombre</span>
                    <span class="info-usuario-value">{{ auth()->user()->nombre }}</span>
                </div>
                <div class="info-usuario-row">
                    <span class="info-usuario-label">Apellidos</span>
                    <span class="info-usuario-value">{{ auth()->user()->apellidos }}</span>
                </div>
                <div class="info-usuario-row">
                    <span class="info-usuario-label">Correo electrónico</span>
                    <span class="info-usuario-value">{{ auth()->user()->email }}</span>
                </div>
                <div class="info-usuario-row">
                    <span class="info-usuario-label">Teléfono</span>
                    <span class="info-usuario-value">{{ auth()->user()->telefono ?: 'No especificado' }}</span>
                </div>
                <div class="info-usuario-row">
                    <span class="info-usuario-label">Rol</span>
                    <span class="info-usuario-value">{{ ucfirst(auth()->user()->rol ?: 'Cliente') }}</span>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
