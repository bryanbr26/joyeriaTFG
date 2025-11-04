<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Joyas</title>
    <style>
        .producto-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .producto-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .precio {
            color: #e44d26;
            font-size: 1.4em;
            font-weight: bold;
        }
        .categoria {
            background: #007bff;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8em;
        }
        .nav-buttons {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="nav-buttons">
        <h1>💎 Joyería - API Funcionando</h1>
        <a href="/" class="btn">🏠 Página Principal</a>
        <a href="{{ route('usuarios.test') }}" class="btn" target="_blank">📋 Ver JSON Usuarios</a>
        <a href="{{ route('categorias.test') }}" class="btn" target="_blank">📁 Ver JSON Categorías</a>
    </div>

    <h2 style="text-align: center;">🎁 Catálogo de Productos</h2>
    
    @if($productos->count() > 0)
        <p style="text-align: center; color: green;">
            ✅ {{ $productos->count() }} productos cargados correctamente
        </p>
        
        <div class="producto-grid">
            @foreach($productos as $producto)
            <div class="producto-card">
                <h3>{{ $producto->nombre }}</h3>
                <p class="precio">{{ $producto->precio }} €</p>
                <p>{{ $producto->descripcion }}</p>
                
                <div style="margin: 10px 0;">
                    <span class="categoria">{{ $producto->categoria->nombre }}</span>
                </div>
                
                <p><strong>Material:</strong> {{ $producto->material }}</p>
                <p><strong>Peso:</strong> {{ $producto->peso }}g</p>
                <p><strong>Stock:</strong> {{ $producto->stock }} unidades</p>
                
                <div style="margin-top: 15px;">
                    <a href="/productos/{{ $producto->id }}" class="btn" target="_blank">
                        🔍 Ver Detalles JSON
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p style="text-align: center; color: red;">❌ No hay productos disponibles</p>
    @endif
</body>
</html>