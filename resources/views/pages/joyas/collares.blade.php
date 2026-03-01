@extends("layouts.layout")

@section("content")

<div class="container my-4">
    <h2>Collares</h2>
    <div class="row g-3">
        @foreach ($collares as $collar)
        <div class="col-md-3">
            <div class="card h-100">
                @if($collar->ruta_grabado && file_exists(public_path('storage/' . $collar->ruta_grabado)))
                    <img src="{{ asset('storage/' . $collar->ruta_grabado) }}" class="card-img-top" alt="{{ $collar->nombre }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $collar->nombre }}</h5>
                    <p class="card-text">{{ $collar->descripcion }}</p>
                    <p class="card-text fw-bold">{{ number_format($collar->precio, 2) }} €</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $collares->links() }}
    </div>
</div>

@endsection