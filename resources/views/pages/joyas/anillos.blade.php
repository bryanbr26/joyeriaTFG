@extends("layouts.layout")

@section("content")

<div class="container my-4">
    <h2>Anillos</h2>
    <div class="row g-3">
        @foreach ($anillos as $anillo)
        <div class="col-md-3">
            <div class="card h-100">
                @if($anillo->ruta_grabado && file_exists(public_path('storage/' . $anillo->ruta_grabado)))
                    <img src="{{ asset('storage/' . $anillo->ruta_grabado) }}" class="card-img-top" alt="{{ $anillo->nombre }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $anillo->nombre }}</h5>
                    <p class="card-text">{{ $anillo->descripcion }}</p>
                    <p class="card-text fw-bold">{{ number_format($anillo->precio, 2) }} €</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $anillos->links() }}
    </div>
</div>

@endsection