@extends("layouts.layout")

@section("content")

<div class="container my-4">
    <h2>Pulseras</h2>
    <div class="row g-3">
        @foreach ($pulseras as $pulsera)
        <div class="col-md-3">
            <div class="card h-100">
                @if($pulsera->ruta_grabado && file_exists(public_path('storage/' . $pulsera->ruta_grabado)))
                    <img src="{{ asset('storage/' . $pulsera->ruta_grabado) }}" class="card-img-top" alt="{{ $pulsera->nombre }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $pulsera->nombre }}</h5>
                    <p class="card-text">{{ $pulsera->descripcion }}</p>
                    <p class="card-text fw-bold">{{ number_format($pulsera->precio, 2) }} €</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $pulseras->links() }}
    </div>
</div>

@endsection