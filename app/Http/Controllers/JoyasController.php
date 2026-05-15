<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JoyasController extends Controller
{
    // Mapa de rutas a categorías de la BBDD
    private function getCategoriaDB($categoria)
    {
        $mapa = [
            'collares' => 'collar',
            'anillos' => 'anillo',
            'pulseras' => 'pulsera',
            'pendientes' => 'pendiente',
        ];
        return $mapa[$categoria] ?? $categoria;
    }

    public function index(Request $request, $categoria)
    {
        $categoriaDB = $this->getCategoriaDB($categoria);

        // Precio máximo real de la categoría para el slider
        // No usamos el precioMax porque ese es despues del filtro y no de todos los productos
        $precioMaximo = (int) ceil(Producto::where('categoria', $categoriaDB)->max('precio') ?? 1000);

        $query = Producto::where('categoria', $categoriaDB);

        // Búsqueda por texto (desde la barra superior)
        if ($request->filled('q')) {
            $busqueda = trim($request->input('q'));
            $query->where(function ($subquery) use ($busqueda) {
                $subquery->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('marca', 'like', "%{$busqueda}%")
                    ->orWhere('descripcion', 'like', "%{$busqueda}%")
                    ->orWhere('material', 'like', "%{$busqueda}%")
                    ->orWhere('color', 'like', "%{$busqueda}%");
            });
        }

        // Filtro marca
        if ($request->filled('marca')) {
            $marcas = (array) $request->input('marca');
            $query->whereIn('marca', $marcas);
        }

        // Filtro género
        if ($request->filled('genero')) {
            $generos = (array) $request->input('genero');
            $query->whereIn('genero', $generos);
        }

        // Filtro color
        if ($request->filled('color')) {
            $colores = (array) $request->input('color');
            $query->whereIn('color', $colores);
        }

        // Filtro material
        if ($request->filled('material')) {
            $materiales = (array) $request->input('material');
            $query->whereIn('material', $materiales);
        }

        // Filtro talla
        if ($request->filled('talla')) {
            $tallas = (array) $request->input('talla');
            $query->whereIn('talla', $tallas);
        }

        // Filtro rango de precio
        $precioMin = $request->has('precio_min') ? (float) $request->input('precio_min') : 0;
        $precioMax = $request->has('precio_max') ? (float) $request->input('precio_max') : $precioMaximo;

        if ($request->has('precio_min') || $request->has('precio_max')) {
            $query->whereBetween('precio', [$precioMin, $precioMax]);
        }

        // Ordenación
        $orden = $request->input('orden');
        if ($orden === 'precio_asc') {
            $query->orderBy('precio', 'asc');
        } elseif ($orden === 'precio_desc') {
            $query->orderBy('precio', 'desc');
        } elseif ($orden === 'ventas') {
            $query->orderBy('id', 'desc'); // Placeholder para más vendidos
        } else {
            $query->orderBy('fecha_agregado', 'desc');
        }

        // appends($request->query()) mantiene los parámetros de la URL al paginar
        $productos = $query->paginate(20)->appends($request->query());
        $titulo = ucfirst($categoria);

        return view('joyas.index', compact('productos', 'categoria', 'titulo', 'precioMaximo', 'precioMin', 'precioMax', 'orden'));
    }

    public function create($categoria)
    {
        $titulo = ucfirst($categoria);
        return view('joyas.create', compact('categoria', 'titulo'));
    }

    public function store(Request $request, $categoria)
    {
        $categoriaDB = $this->getCategoriaDB($categoria);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'genero' => 'required|string',
            'color' => 'required|string',
            'talla' => 'nullable|string',
            'material' => 'nullable|string',
            'peso' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        $datos = $request->except('imagen');
        $datos['categoria'] = $categoriaDB;

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('productos', 'public');
            $datos['ruta_grabado'] = $ruta;
        }

        Producto::create($datos);

        return redirect()->route('joyas.index', $categoria)->with('success', ucfirst($categoriaDB) . ' creado correctamente.');
    }

    public function edit($categoria, Producto $producto)
    {
        $titulo = ucfirst($categoria);
        return view('joyas.edit', compact('producto', 'categoria', 'titulo'));
    }

    public function update(Request $request, $categoria, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'genero' => 'required|string',
            'color' => 'required|string',
            'talla' => 'nullable|string',
            'material' => 'nullable|string',
            'peso' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        $datos = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            if ($producto->ruta_grabado && Storage::disk('public')->exists($producto->ruta_grabado)) {
                Storage::disk('public')->delete($producto->ruta_grabado);
            }
            $ruta = $request->file('imagen')->store('productos', 'public');
            $datos['ruta_grabado'] = $ruta;
        }

        $producto->update($datos);

        return redirect()->route('joyas.index', $categoria)->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($categoria, Producto $producto)
    {
        if ($producto->ruta_grabado && Storage::disk('public')->exists($producto->ruta_grabado)) {
            Storage::disk('public')->delete($producto->ruta_grabado);
        }

        $producto->delete();

        return redirect()->route('joyas.index', $categoria)->with('success', 'Producto eliminado correctamente.');
    }

    public function show($categoria, Producto $producto)
    {
        $titulo = $producto->nombre;
        $categoriaDB = $this->getCategoriaDB($categoria);

        // Obtenemos otros productos de la misma categoría para el carrusel/showcase
        $productos = Producto::where('categoria', $categoriaDB)
            ->where('id', '!=', $producto->id)
            ->get();

        return view('joyas.show', compact('producto', 'categoria', 'titulo', 'productos'));
    }

    /**
     * Búsqueda AJAX de productos para el header.
     */
    public function buscar(Request $request)
    {
        $query = trim($request->input('q', ''));

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $productos = Producto::where('nombre', 'like', "%{$query}%")
            ->orWhere('marca', 'like', "%{$query}%")
            ->orWhere('descripcion', 'like', "%{$query}%")
            ->orWhere('material', 'like', "%{$query}%")
            ->limit(4)
            ->get();

        $mapaCategorias = [
            'collar' => 'collares',
            'anillo' => 'anillos',
            'pulsera' => 'pulseras',
            'pendiente' => 'pendientes',
        ];

        $resultado = $productos->map(function ($producto) use ($mapaCategorias) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'marca' => $producto->marca,
                'descripcion' => $producto->descripcion,
                'precio' => $producto->precio,
                'ruta_grabado' => $producto->ruta_grabado,
                'imagen_url' => $producto->imagenUrl('medium'),
                'placeholder_url' => $producto->placeholder,
                'categoria' => $mapaCategorias[$producto->categoria] ?? $producto->categoria,
            ];
        });

        return response()->json($resultado);
    }

}

