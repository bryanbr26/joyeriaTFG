<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Carrito;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PersonalizaController extends Controller
{
    /**
     * Vista genérica de personalización (sin producto, acceso desde nav).
     */
    public function personaliza()
    {
        return view('pages.personaliza', ['producto' => null]);
    }

    /**
     * Vista de personalización vinculada a un producto específico.
     */
    public function personalizaProducto(Producto $producto)
    {
        $producto->load('imagenes');

        return view('pages.personaliza', compact('producto'));
    }

    /**
     * Guarda la imagen del grabado y añade el producto personalizado al carrito.
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

    public function mostrarGrabadoCarrito(Carrito $carrito)
    {
        $usuario = Auth::user();

        abort_unless($usuario && ($carrito->id_usuario === $usuario->id || $usuario->rol === 'admin'), 403);

        return $this->respuestaGrabado($carrito->ruta_grabado_personalizado);
    }

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

    private function respuestaGrabado(?string $ruta)
    {
        abort_if(!$ruta || strpos($ruta, 'grabados/') !== 0 || strpos($ruta, '..') !== false, 404);
        abort_unless(Storage::disk('public')->exists($ruta), 404);

        return Storage::disk('public')->response($ruta);
    }
}
