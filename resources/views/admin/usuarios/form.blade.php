@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="admin-form-grid">
        <div>
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', optional($usuario)->nombre) }}" required>
        </div>
        <div>
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos', optional($usuario)->apellidos) }}" required>
        </div>
        <div>
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', optional($usuario)->email) }}" required>
        </div>
        <div>
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" {{ $usuario ? '' : 'required' }}>
            @if($usuario)
                <small class="text-muted">Déjala vacía para mantener la actual.</small>
            @endif
        </div>
        <div>
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', optional($usuario)->telefono) }}">
        </div>
        <div>
            <label for="rol" class="form-label">Rol</label>
            <input type="text" name="rol" value="admin" class="form-control" id="rol" style="text-transform: capitalize; background-color: #e9ecef;" readonly>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-dark">{{ $submit }}</button>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
