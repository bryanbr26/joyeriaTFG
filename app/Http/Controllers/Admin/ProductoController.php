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
        $datos['ruta_grabado'] = $request->file('imagen')->store('productos', 'public');

        Producto::create($datos);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        return view('admin.productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $datos = $this->validateProducto($request, false);

        if ($request->hasFile('imagen')) {
            $this->deleteProductoImage($producto);
            $datos['ruta_grabado'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($datos);

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
        $this->deleteProductoImage($producto);
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
            'imagen' => ($creating ? 'required' : 'nullable') . '|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);
    }

    private function deleteProductoImage(Producto $producto): void
    {
        if ($producto->ruta_grabado && Storage::disk('public')->exists($producto->ruta_grabado)) {
            Storage::disk('public')->delete($producto->ruta_grabado);
        }
    }
}
