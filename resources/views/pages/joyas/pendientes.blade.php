@extends("layouts.layout")

@section("content")

<div class="container my-4">
    <h2>Pendientes</h2>
    <div class="row g-3">
        @foreach ($pendientes as $pendiente)
        <div class="col-md-3">
            <div class="card h-100">
                @if($pendiente->ruta_grabado && file_exists(public_path('storage/' . $pendiente->ruta_grabado)))
                    <img src="{{ asset('storage/' . $pendiente->ruta_grabado) }}" class="card-img-top" alt="{{ $pendiente->nombre }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $pendiente->nombre }}</h5>
                    <p class="card-text">{{ $pendiente->descripcion }}</p>
                    <p class="card-text fw-bold">{{ number_format($pendiente->precio, 2) }} €</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $pendientes->links() }}
    </div>
</div>

@endsection