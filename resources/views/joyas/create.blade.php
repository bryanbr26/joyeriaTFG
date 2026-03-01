@extends("layouts.layout")

@section("title", "Crear " . rtrim($titulo, 's'))

@section("content")

<div class="container my-4">
    <h2>Crear {{ rtrim($titulo, 's') }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('joyas.store', $categoria) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" value="{{ old('marca') }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="genero" class="form-label">Género</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="">Seleccionar...</option>
                    <option value="mujer" {{ old('genero') == 'mujer' ? 'selected' : '' }}>Mujer</option>
                    <option value="hombre" {{ old('genero') == 'hombre' ? 'selected' : '' }}>Hombre</option>
                    <option value="unisex" {{ old('genero') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="color" class="form-label">Color</label>
                <input type="text" class="form-control" id="color" name="color" value="{{ old('color') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="material" class="form-label">Material</label>
                <input type="text" class="form-control" id="material" name="material" value="{{ old('material') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="precio" class="form-label">Precio (€)</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="peso" class="form-label">Peso (g)</label>
                <input type="number" step="0.01" class="form-control" id="peso" name="peso" value="{{ old('peso') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="talla" class="form-label">Talla</label>
                <input type="text" class="form-control" id="talla" name="talla" value="{{ old('talla') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen del producto</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            <small class="text-muted">Formatos: JPEG, PNG, GIF, WebP. Máx: 2MB</small>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-dark">Crear Producto</button>
            <a href="{{ route('joyas.index', $categoria) }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>

@endsection
