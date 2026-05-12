<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $productos = Producto::query()
            ->with('imagenes')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->input('buscar');
                $query->where(function ($subquery) use ($buscar) {
                    $subquery->where('nombre', 'like', '%' . $buscar . '%')
                        ->orWhere('marca', 'like', '%' . $buscar . '%');
                });
            })
            ->when($request->filled('categoria'), function ($query) use ($request) {
                $query->where('categoria', $request->input('categoria'));
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.productos.create');
    }

    public function store(Request $request)
    {
        $datos = $this->validateProducto($request, true);
        unset($datos['imagenes']);
        $datos['ruta_grabado'] = '';

        $producto = Producto::create($datos);
        $this->storeProductoImages($request, $producto);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $producto->load('imagenes');

        return view('admin.productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $datos = $this->validateProducto($request, false);
        unset($datos['imagenes']);

        $producto->update($datos);
        $this->storeProductoImages($request, $producto);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function updateStock(Request $request, Producto $producto)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $producto->update(['stock' => $request->input('stock')]);

        return back()->with('success', 'Stock actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $this->deleteProductoImages($producto);
        $producto->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    private function validateProducto(Request $request, bool $creating): array
    {
        return $request->validate([
            'categoria' => 'required|in:anillo,pulsera,pendiente,collar',
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'genero' => 'required|in:hombre,mujer,unisex',
            'color' => 'required|string|max:255',
            'talla' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'peso' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagenes' => ($creating ? 'required' : 'nullable') . '|array|min:1',
            'imagenes.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);
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
