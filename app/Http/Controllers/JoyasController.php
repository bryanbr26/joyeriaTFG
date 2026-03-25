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

        // Filtro marca
        if ($request->filled('marca')) {
            $query->whereIn('marca', $request->input('marca'));
        }

        // Filtro género
        if ($request->filled('genero')) {
            $query->whereIn('genero', $request->input('genero'));
        }

        // Filtro color
        if ($request->filled('color')) {
            $query->whereIn('color', $request->input('color'));
        }

        // Filtro material
        if ($request->filled('material')) {
            $query->whereIn('material', $request->input('material'));
        }

        // Filtro talla
        if ($request->filled('talla')) {
            $query->whereIn('talla', $request->input('talla'));
        }

        // Filtro rango de precio (usamos has() en vez de filled() porque filled() toma el 0 como vacio)
        $precioMin = $request->has('precio_min') ? (float)$request->input('precio_min') : 0;
        $precioMax = $request->has('precio_max') ? (float)$request->input('precio_max') : $precioMaximo;

        if ($request->has('precio_min') || $request->has('precio_max')) {
            $query->whereBetween('precio', [$precioMin, $precioMax]);
        }

        // Ordenación
        $orden = $request->input('orden');
        if ($orden === 'precio_asc') {
            $query->orderBy('precio', 'asc');
        } elseif ($orden === 'precio_desc') {
            $query->orderBy('precio', 'desc');
        }

        // appends($request->query()) mantiene los parámetros de la URL al paginar
        $productos = $query->paginate(8)->appends($request->query());
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
}
