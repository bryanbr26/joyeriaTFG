<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias de Joyas</title>
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
        <a href="/productos" class="btn" target="_blank">📋 Ver JSON Productos</a>
        <a href="/usuarios" class="btn" target="_blank">📁 Ver JSON Usuarios</a>
    </div>

    <h2 style="text-align: center;">Categorías de los productos</h2>
    <!-- Comprobar si existe alguna categoria -->
    @if($categorias->count() > 0) 
        <p style="text-align: center; color: green;">
            ✅ {{ $categorias->count() }} categorías cargadas correctamente  {{-- Usamos la funcion count de la coleccion de categorias --}}
        </p>
        
        <div class="producto-grid">
            @foreach($categorias as $categoria)
            <div class="producto-card">
                <h3>{{ $categoria->nombre }}</h3>
                <p>{{ $categoria->descripcion }}</p>
                <p><strong>Productos:</strong></p>
                <ul>
                    @foreach($categoria->productos as $producto)
                        <li>{{ $producto->nombre }} - {{ $producto->precio }} €</li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    @else
        <p style="text-align: center; color: red;">❌ No hay categorías disponibles</p>
    @endif
</body>
</html>