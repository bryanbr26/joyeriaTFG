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

    public function indexAll(Request $request)
    {
        return $this->listado($request, null);
    }

    public function index(Request $request, $categoria)
    {
        return $this->listado($request, $categoria);
    }

    private function listado(Request $request, $categoria = null)
    {
        $categoriaDB = $this->getCategoriaDB($categoria);
        $baseQuery = Producto::query();

        if ($categoria) {
            $baseQuery->where('categoria', $categoriaDB);
        }

        // Precio máximo real para el slider.
        // No usamos el precioMax porque ese es despues del filtro y no de todos los productos
        $precioMaximo = (int) ceil((clone $baseQuery)->max('precio') ?? 1000);
        $precioMaximo = max($precioMaximo, 1);

        $query = (clone $baseQuery)->with('imagenes');

        // Búsqueda por texto desde la barra superior.
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
        } else {
            $query->orderBy('fecha_agregado', 'desc')->orderBy('id', 'desc');
        }

        $marcas = (clone $baseQuery)->whereNotNull('marca')->distinct()->orderBy('marca')->pluck('marca');
        $generos = (clone $baseQuery)->whereNotNull('genero')->distinct()->orderBy('genero')->pluck('genero');
        $colores = (clone $baseQuery)->whereNotNull('color')->distinct()->orderBy('color')->pluck('color');
        $materiales = (clone $baseQuery)->whereNotNull('material')->distinct()->orderBy('material')->pluck('material');
        $tallas = (clone $baseQuery)->whereNotNull('talla')->distinct()->orderBy('talla')->pluck('talla');
        $categoriaUrlByDb = [
            'collar' => 'collares',
            'anillo' => 'anillos',
            'pulsera' => 'pulseras',
            'pendiente' => 'pendientes',
        ];

        // appends($request->query()) mantiene los parámetros de la URL al paginar
        $productos = $query->paginate(20)->appends($request->query());
        $titulo = $categoria ? ucfirst($categoria) : 'Joyería';

        return view('joyas.index', compact(
            'productos',
            'categoria',
            'titulo',
            'precioMaximo',
            'precioMin',
            'precioMax',
            'orden',
            'marcas',
            'generos',
            'colores',
            'materiales',
            'tallas',
            'categoriaUrlByDb'
        ));
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
            'imagenes' => 'nullable|array|min:1',
            'imagenes.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        $datos = $request->except('imagenes');
        $datos['categoria'] = $categoriaDB;
        $datos['ruta_grabado'] = '';

        $producto = Producto::create($datos);
        $this->storeProductoImages($request, $producto);

        return redirect()->route('joyas.index', $categoria)->with('success', ucfirst($categoriaDB) . ' creado correctamente.');
    }

    public function edit($categoria, Producto $producto)
    {
        $producto->load('imagenes');
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
            'imagenes' => 'nullable|array|min:1',
            'imagenes.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        $datos = $request->except('imagenes');

        $producto->update($datos);
        $this->storeProductoImages($request, $producto);

        return redirect()->route('joyas.index', $categoria)->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($categoria, Producto $producto)
    {
        $this->deleteProductoImages($producto);

        $producto->delete();

        return redirect()->route('joyas.index', $categoria)->with('success', 'Producto eliminado correctamente.');
    }

    public function show($categoria, Producto $producto)
    {
        $producto->load('imagenes');
        $titulo = $producto->nombre;

        return view('joyas.show', compact('producto', 'categoria', 'titulo'));
    }

    private function storeProductoImages(Request $request, Producto $producto): void
    {
        if (!$request->hasFile('imagenes')) {
            return;
        }

        $hasPrincipal = $producto->imagenes()->where('principal', true)->exists();

        foreach ($request->file('imagenes') as $index => $imagen) {
            $ruta = $imagen->store('productos', 's3');

            $producto->imagenes()->create([
                'url' => $ruta,
                'principal' => !$hasPrincipal && $index === 0,
            ]);

            if ($index === 0) {
                $producto->update(['ruta_grabado' => $ruta]);
            }
        }
    }

    private function deleteProductoImages(Producto $producto): void
    {
        foreach ($producto->imagenes as $imagen) {
            if (!preg_match('/^https?:\/\//', $imagen->url) && Storage::disk('s3')->exists($imagen->url)) {
                Storage::disk('s3')->delete($imagen->url);
            }

            $imagen->delete();
        }
    }

}

