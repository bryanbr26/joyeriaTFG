<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Carrito;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * PersonalizaController - Gestiona la personalización de productos con grabados.
 *
 * Permite a los usuarios diseñar grabados personalizados sobre productos
 * de joyería y gestionar su visualización tanto en carrito como en pedidos.
 */
class PersonalizaController extends Controller
{
    /**
     * Catálogo de productos grabables (acceso desde nav, sin producto).
     *
     * Lista únicamente los productos con es_grabable = true, con filtros
     * opcionales por categoría y material para los submenús del header.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function personaliza(Request $request)
    {
        $categoria = $request->input('categoria');
        $material = $request->input('material');

        $consulta = Producto::with('imagenes')->where('es_grabable', true);

        $nombresCategoria = [
            'anillo' => 'anillos',
            'pulsera' => 'pulseras',
            'pendiente' => 'pendientes',
            'collar' => 'collares',
        ];

        $subtitulo = null;

        if ($categoria && isset($nombresCategoria[$categoria])) {
            $consulta->where('categoria', $categoria);
            $subtitulo = 'Grabado de ' . $nombresCategoria[$categoria];
        }

        if ($material) {
            $materiales = array_map('strtolower', (array) $material);
            $consulta->whereIn('material', $materiales);
            $subtitulo = 'Material: ' . implode(', ', array_map('ucfirst', $materiales));
        }

        $productos = $consulta->orderBy('categoria')->orderBy('nombre')
            ->paginate(12)
            ->appends($request->query());

        return view('pages.personaliza-catalogo', [
            'productos' => $productos,
            'titulo' => 'Personaliza tus joyas',
            'subtitulo' => $subtitulo,
        ]);
    }

    /**
     * Vista de personalización vinculada a un producto específico.
     *
     * @param \App\Models\Producto $producto Producto a personalizar
     * @return \Illuminate\View\View
     */
    public function personalizaProducto(Producto $producto)
    {
        if (!$producto->es_grabable) {
            abort(404);
        }

        $producto->load('imagenes');

        return view('pages.personaliza', compact('producto'));
    }

    /**
     * Guarda la imagen del grabado y añade el producto personalizado al carrito.
     *
     * Decodifica una imagen base64, la almacena en disco y crea una entrada
     * única en el carrito vinculada al grabado personalizado.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function guardarGrabado(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $request->validate([
            'imagen_base64' => 'required|string',
            'producto_id' => 'required|integer|exists:PRODUCTO,id'
        ]);

        $producto = Producto::findOrFail($request->input('producto_id'));

        if (!$producto->es_grabable) {
            return response()->json([
                'success' => false,
                'message' => 'Este producto no admite grabado personalizado'
            ], 422);
        }

        // Verificar stock considerando TODAS las unidades de este producto en el carrito
        $totalEnCarrito = Carrito::where('id_usuario', Auth::id())
                                ->where('id_producto', $producto->id)
                                ->sum('cantidad');

        if ($totalEnCarrito >= $producto->stock) {
            return response()->json([
                'success' => false,
                'message' => 'No hay stock disponible de este producto (ya tienes ' . $totalEnCarrito . ' en la cesta)'
            ]);
        }

        // Decodificar imagen base64 y guardar en storage
        $imagenBase64 = $request->input('imagen_base64');
        // Eliminar el prefijo data:image/png;base64, si existe
        $imagenBase64 = preg_replace('/^data:image\/\w+;base64,/', '', $imagenBase64);
        $imagenBinaria = base64_decode($imagenBase64);

        if (!$imagenBinaria) {
            return response()->json(['success' => false, 'message' => 'Imagen inválida']);
        }

        // Generar nombre único para el archivo
        $nombreArchivo = 'grabados/' . Auth::id() . '_' . $producto->id . '_' . time() . '.png';

        // Guardar en storage/app/public/grabados/
        Storage::disk('public')->put($nombreArchivo, $imagenBinaria);

        $userId = Auth::id();

        // Los productos personalizados siempre son entradas nuevas en el carrito
        // (cada grabado es único, no se agrupan)
        Carrito::create([
            'id_usuario' => $userId,
            'id_producto' => $producto->id,
            'cantidad' => 1,
            'ruta_grabado_personalizado' => $nombreArchivo
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto personalizado añadido a la cesta correctamente',
            'totalItems' => Carrito::where('id_usuario', $userId)->sum('cantidad')
        ]);
    }

    /**
     * Muestra la imagen de grabado asociada a un item del carrito.
     *
     * @param \App\Models\Carrito $carrito Item del carrito
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function mostrarGrabadoCarrito(Carrito $carrito)
    {
        $usuario = Auth::user();

        abort_unless($usuario && ($carrito->id_usuario === $usuario->id || $usuario->rol === 'admin'), 403);

        return $this->respuestaGrabado($carrito->ruta_grabado_personalizado);
    }

    /**
     * Muestra la imagen de grabado asociada a un detalle de pedido.
     *
     * @param \App\Models\DetallePedido $detalle Línea de detalle del pedido
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function mostrarGrabadoPedido(DetallePedido $detalle)
    {
        $usuario = Auth::user();
        $detalle->loadMissing('pedido');

        abort_unless(
            $usuario && $detalle->pedido && ($detalle->pedido->id_usuario === $usuario->id || $usuario->rol === 'admin'),
            403
        );

        return $this->respuestaGrabado($detalle->ruta_grabado_personalizado);
    }

    /**
     * Genera la respuesta HTTP con la imagen del grabado desde disco.
     *
     * @param string|null $ruta Ruta relativa del archivo en disco público
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    private function respuestaGrabado(?string $ruta)
    {
        abort_if(!$ruta || strpos($ruta, 'grabados/') !== 0 || strpos($ruta, '..') !== false, 404);
        abort_unless(Storage::disk('public')->exists($ruta), 404);

        return Storage::disk('public')->response($ruta);
    }
}
