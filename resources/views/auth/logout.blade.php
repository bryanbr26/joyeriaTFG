@extends('layouts.layout')

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh;">
    <div class="text-center">
        <i class="bi bi-box-arrow-right" style="font-size: 3rem;"></i>
        <h3 class="mt-3">Cerrando sesión...</h3>
        <p class="text-muted">Serás redirigido a la página de inicio en unos segundos.</p>
    </div>
</div>

<script>
    setTimeout(function () {
        window.location.href = "{{ route('index') }}";
    }, 1500);
</script>
@endsection
