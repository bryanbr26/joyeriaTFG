<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::paginate(10);
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria' => 'required|in:anillo,pulsera,pendiente,collar',
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
            $ruta = $request->file('imagen')->store('productos', 'public');
            $datos['ruta_grabado'] = $ruta;
        }

        Producto::create($datos);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'categoria' => 'required|in:anillo,pulsera,pendiente,collar',
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
            // Eliminar imagen anterior si existe
            if ($producto->ruta_grabado && Storage::disk('public')->exists($producto->ruta_grabado)) {
                Storage::disk('public')->delete($producto->ruta_grabado);
            }
            $ruta = $request->file('imagen')->store('productos', 'public');
            $datos['ruta_grabado'] = $ruta;
        }

        $producto->update($datos);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        // Eliminar imagen si existe
        if ($producto->ruta_grabado && Storage::disk('public')->exists($producto->ruta_grabado)) {
            Storage::disk('public')->delete($producto->ruta_grabado);
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
