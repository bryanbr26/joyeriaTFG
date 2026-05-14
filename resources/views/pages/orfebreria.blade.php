@extends("layouts.layout")

@section("content")

<div class="container my-5">
    <div class="text-center py-5">
        <i class="bi bi-hammer fs-1 text-muted"></i>
        <h2 class="mt-3">Orfebrería</h2>
        <p class="text-muted fs-5">Reparación, ajuste y cuidado de joyas</p>
        <p class="text-muted">En nuestro taller revisamos cierres, tallas, engastes y acabados para que tus piezas vuelvan a lucir como el primer día.</p>
        <a href="{{ route('index') }}" class="btn btn-outline-dark mt-3">Volver al inicio</a>
    </div>
</div>

@endsection
