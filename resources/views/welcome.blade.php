<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joyería - TFG</title>
</head>
<body>
    
    <h2>Probando conexión a BD</h2>
    
    @php
        // Usar DB facade directamente
        try {
            $productos = DB::table('PRODUCTO')->get();
            echo "<p style='color: green;'>Conexión exitosa a la base de datos</p>";
            echo "<p>Número de productos: " . count($productos) . "</p>";
            
            // Mostrar algunos productos
            foreach($productos->take(5) as $producto) {
                echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 5px;'>";
                echo "<h3>" . $producto->nombre . "</h3>";
                echo "<p>Precio: " . $producto->precio . "€</p>";
                echo "</div>";
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
    @endphp
</body>
</html>