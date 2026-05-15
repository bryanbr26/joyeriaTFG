<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * ProductoController - Gestiona el CRUD de productos del catálogo.
 *
 * Permite listar, crear, editar y eliminar productos de joyería,
 * gestionando también la subida de imágenes al almacenamiento S3.
 */
class ProductoController extends Controller
{
    /**
     * Muestra el listado paginado de todos los productos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $productos = Producto::paginate(10);
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     *
     * Valida los datos de entrada, sube la imagen a S3 si se proporciona
     * y crea el registro del producto.
     *
     * @param \Illuminate\Http\Request $request Datos del formulario
     * @return \Illuminate\Http\RedirectResponse
     */
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
            $ruta = $request->file('imagen')->store('productos', 's3');
            $datos['ruta_grabado'] = $ruta;
        }

        Producto::create($datos);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un producto existente.
     *
     * @param \App\Models\Producto $producto Producto a editar
     * @return \Illuminate\View\View
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     *
     * Valida los datos, elimina la imagen anterior de S3 si se sube una nueva
     * y actualiza el registro.
     *
     * @param \Illuminate\Http\Request $request Datos del formulario
     * @param \App\Models\Producto $producto Producto a actualizar
     * @return \Illuminate\Http\RedirectResponse
     */
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
            if ($producto->ruta_grabado && Storage::disk('s3')->exists($producto->ruta_grabado)) {
                Storage::disk('s3')->delete($producto->ruta_grabado);
            }
            $ruta = $request->file('imagen')->store('productos', 's3');
            $datos['ruta_grabado'] = $ruta;
        }

        $producto->update($datos);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto del catálogo y su imagen asociada de S3.
     *
     * @param \App\Models\Producto $producto Producto a eliminar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Producto $producto)
    {
        // Eliminar imagen si existe
        if ($producto->ruta_grabado && Storage::disk('s3')->exists($producto->ruta_grabado)) {
            Storage::disk('s3')->delete($producto->ruta_grabado);
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
