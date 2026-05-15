<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImagenProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * ProductoController (Admin) - Gestión completa del catálogo de productos.
 *
 * Permite listar con búsqueda, crear, editar, actualizar stock y eliminar
 * productos junto con el manejo de sus imágenes en S3.
 */
class ProductoController extends Controller
{
    /**
     * Muestra el listado paginado de productos con filtros de búsqueda y categoría.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
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

    /**
     * Muestra el formulario de creación de producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.productos.create');
    }

    /**
     * Almacena un nuevo producto en el catálogo.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $datos = $this->validateProducto($request, true);
        unset($datos['imagenes']);
        $datos['ruta_grabado'] = '';

        $producto = Producto::create($datos);
        $this->storeProductoImages($request, $producto);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Muestra el formulario de edición de un producto.
     *
     * @param \App\Models\Producto $producto Producto a editar
     * @return \Illuminate\View\View
     */
    public function edit(Producto $producto)
    {
        $producto->load('imagenes');

        return view('admin.productos.edit', compact('producto'));
    }

    /**
     * Actualiza un producto existente y sincroniza sus imágenes.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Producto $producto Producto a actualizar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Producto $producto)
    {
        $datos = $this->validateProducto($request, false);
        unset($datos['imagenes']);
        unset($datos['imagenes_eliminar']);

        $producto->update($datos);
        $this->deleteSelectedProductoImages($request, $producto);
        $this->storeProductoImages($request, $producto);
        $this->syncPrincipalImage($producto);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Actualiza únicamente el stock de un producto.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Producto $producto Producto a actualizar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStock(Request $request, Producto $producto)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $producto->update(['stock' => $request->input('stock')]);

        return back()->with('success', 'Stock actualizado correctamente.');
    }

    /**
     * Elimina un producto y todas sus imágenes asociadas.
     *
     * @param \App\Models\Producto $producto Producto a eliminar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Producto $producto)
    {
        $this->deleteProductoImages($producto);
        $producto->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Valida los datos de un producto según si es creación o edición.
     *
     * @param \Illuminate\Http\Request $request
     * @param bool $creating Indica si es una creación (true) o edición (false)
     * @return array Datos validados
     */
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
            'imagenes_eliminar' => 'nullable|array',
            'imagenes_eliminar.*' => 'integer|exists:IMAGENES_PRODUCTO,id',
        ]);
    }

    /**
     * Elimina las imágenes seleccionadas de un producto.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Producto $producto
     * @return void
     */
    private function deleteSelectedProductoImages(Request $request, Producto $producto): void
    {
        $imageIds = $request->input('imagenes_eliminar', []);

        if (empty($imageIds)) {
            return;
        }

        $imagenes = $producto->imagenes()
            ->whereIn('id', $imageIds)
            ->get();

        foreach ($imagenes as $imagen) {
            $this->deleteProductoImageFile($imagen);
            $imagen->delete();
        }
    }

    /**
     * Almacena las imágenes subidas para un producto en S3.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Producto $producto
     * @return void
     */
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

    /**
     * Elimina todas las imágenes de un producto incluyendo los archivos en S3.
     *
     * @param \App\Models\Producto $producto
     * @return void
     */
    private function deleteProductoImages(Producto $producto): void
    {
        foreach ($producto->imagenes as $imagen) {
            $this->deleteProductoImageFile($imagen);
            $imagen->delete();
        }
    }

    /**
     * Elimina el archivo de imagen de S3 si no es una URL externa.
     *
     * @param \App\Models\ImagenProducto $imagen
     * @return void
     */
    private function deleteProductoImageFile(ImagenProducto $imagen): void
    {
        if (!preg_match('/^https?:\/\//', $imagen->url) && Storage::disk('s3')->exists($imagen->url)) {
            Storage::disk('s3')->delete($imagen->url);
        }
    }

    /**
     * Sincroniza la imagen principal del producto y actualiza la ruta de grabado.
     *
     * @param \App\Models\Producto $producto
     * @return void
     */
    private function syncPrincipalImage(Producto $producto): void
    {
        $producto->load('imagenes');
        $principal = $producto->imagenes->firstWhere('principal', true);

        if (!$principal && $producto->imagenes->isNotEmpty()) {
            $principal = $producto->imagenes->first();
            $principal->update(['principal' => true]);
        }

        $producto->update([
            'ruta_grabado' => $principal ? $principal->url : '',
        ]);
    }
}
