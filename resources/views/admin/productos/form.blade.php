@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="admin-form-grid">
        <div>
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', optional($producto)->nombre) }}" required>
        </div>
        <div>
            <label for="marca" class="form-label">Marca</label>
            <input type="text" id="marca" name="marca" class="form-control" value="{{ old('marca', optional($producto)->marca) }}" required>
        </div>
        <div>
            <label for="categoria" class="form-label">Categoría</label>
            <select id="categoria" name="categoria" class="form-select" required>
                <option value="">Seleccionar...</option>
                @foreach(['anillo' => 'Anillo', 'pulsera' => 'Pulsera', 'pendiente' => 'Pendiente', 'collar' => 'Collar'] as $value => $label)
                    <option value="{{ $value }}" {{ old('categoria', optional($producto)->categoria) === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="genero" class="form-label">Género</label>
            <select id="genero" name="genero" class="form-select" required>
                <option value="">Seleccionar...</option>
                @foreach(['mujer' => 'Mujer', 'hombre' => 'Hombre', 'unisex' => 'Unisex'] as $value => $label)
                    <option value="{{ $value }}" {{ old('genero', optional($producto)->genero) === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="full">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4" class="form-control" required>{{ old('descripcion', optional($producto)->descripcion) }}</textarea>
        </div>
        <div>
            <label for="precio" class="form-label">Precio</label>
            <input type="number" id="precio" name="precio" class="form-control" step="0.01" min="0" value="{{ old('precio', optional($producto)->precio) }}" required>
        </div>
        <div>
            <label for="stock" class="form-label">Stock</label>
            <input type="number" id="stock" name="stock" class="form-control" min="0" value="{{ old('stock', optional($producto)->stock) }}" required>
        </div>
        <div>
            <label for="color" class="form-label">Color</label>
            <input type="text" id="color" name="color" class="form-control" value="{{ old('color', optional($producto)->color) }}" required>
        </div>
        <div>
            <label for="material" class="form-label">Material</label>
            <input type="text" id="material" name="material" class="form-control" value="{{ old('material', optional($producto)->material) }}">
        </div>
        <div>
            <label for="talla" class="form-label">Talla</label>
            <input type="text" id="talla" name="talla" class="form-control" value="{{ old('talla', optional($producto)->talla) }}">
        </div>
        <div>
            <label for="peso" class="form-label">Peso</label>
            <input type="number" id="peso" name="peso" class="form-control" step="0.01" min="0" value="{{ old('peso', optional($producto)->peso) }}">
        </div>
        <div class="full">
            <label for="imagenes" class="form-label">Imágenes</label>
            @if($producto && $producto->imagenes->isNotEmpty())
                <div class="d-flex gap-2 flex-wrap mb-2">
                    @foreach($producto->imagenes as $imagen)
                        <div>
                            <img src="{{ $imagen->url_completa }}" alt="{{ $producto->nombre }}" class="admin-product-thumb">
                            @if($imagen->principal)
                                <span class="badge bg-dark d-block mt-1">Principal</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
            <input type="file" id="imagenes" name="imagenes[]" class="form-control" accept="image/*" multiple {{ $imageRequired ? 'required' : '' }}>
            <small class="text-muted">Puedes subir una o varias imágenes. La primera será la principal. En edición, las nuevas imágenes se añaden a las existentes. JPEG, PNG, GIF o WebP. Máximo 2MB por imagen.</small>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-dark">{{ $submit }}</button>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
