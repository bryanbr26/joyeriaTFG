@extends("layouts.layout")

@section("content")

<div>
    <h2>Collares</h2>
    <div class="d-flex flex-row gap-3 justify-content-around align-items-center">
        @foreach ($collares as $collar)
        <div>
            <h3>{{ $collar->nombre }}</h3>
            <p>{{ $collar->descripcion }}</p>
            <p>{{ $collar->precio }}</p>
        </div>
        @endforeach
    </div>

</div>

@endsection