@extends("layouts.layout")

@section("title", "Editar Producto")

@section("content")

<div class="container my-4">
    <h2>Editar Producto: {{ $producto->nombre }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" value="{{ old('marca', $producto->marca) }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="anillo" {{ old('categoria', $producto->categoria) == 'anillo' ? 'selected' : '' }}>Anillo</option>
                    <option value="pulsera" {{ old('categoria', $producto->categoria) == 'pulsera' ? 'selected' : '' }}>Pulsera</option>
                    <option value="pendiente" {{ old('categoria', $producto->categoria) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="collar" {{ old('categoria', $producto->categoria) == 'collar' ? 'selected' : '' }}>Collar</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="genero" class="form-label">Género</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="mujer" {{ old('genero', $producto->genero) == 'mujer' ? 'selected' : '' }}>Mujer</option>
                    <option value="hombre" {{ old('genero', $producto->genero) == 'hombre' ? 'selected' : '' }}>Hombre</option>
                    <option value="unisex" {{ old('genero', $producto->genero) == 'unisex' ? 'selected' : '' }}>Unisex</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="color" class="form-label">Color</label>
                <input type="text" class="form-control" id="color" name="color" value="{{ old('color', $producto->color) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="precio" class="form-label">Precio (€)</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="peso" class="form-label">Peso (g)</label>
                <input type="number" step="0.01" class="form-control" id="peso" name="peso" value="{{ old('peso', $producto->peso) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="talla" class="form-label">Talla</label>
                <input type="text" class="form-control" id="talla" name="talla" value="{{ old('talla', $producto->talla) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="material" class="form-label">Material</label>
                <input type="text" class="form-control" id="material" name="material" value="{{ old('material', $producto->material) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="imagen" class="form-label">Imagen del producto</label>
                @if($producto->ruta_grabado)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $producto->ruta_grabado) }}" alt="{{ $producto->nombre }}" width="100" height="100" style="object-fit: cover;" class="border rounded">
                        <small class="d-block text-muted">Imagen actual</small>
                    </div>
                @endif
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                <small class="text-muted">Dejar vacío para mantener la imagen actual</small>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-dark">Guardar Cambios</button>
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>

@endsection
