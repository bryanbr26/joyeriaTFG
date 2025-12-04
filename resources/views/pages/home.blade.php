@extends("layouts.layout")

@section("content")

<div>
    @if(auth()->user())
    Este es el home, bienvenido {{ auth()->user()->nombre}} {{ auth()->user()->apellidos}}
    @else
    No estas logueado
    @endif
</div>

@endsection