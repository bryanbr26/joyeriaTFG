<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function agregar(Request $request, Producto $producto)
    {
        // Requerir autenticación
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $userId = Auth::id();

        // Comprobar si el producto ya está en el carrito del usuario
        $carritoItem = Carrito::where('id_usuario', $userId)
                              ->where('id_producto', $producto->id)
                              ->first();

        if ($carritoItem) {
            // Si ya existe, incrementar la cantidad (respetando stock)
            if ($carritoItem->cantidad >= $producto->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay más stock disponible de este producto'
                ]);
            }
            $carritoItem->cantidad += 1;
            $carritoItem->save();
        } else {
            // Si no existe, crear un nuevo registro
            if ($producto->stock <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto agotado'
                ]);
            }
            Carrito::create([
                'id_usuario' => $userId,
                'id_producto' => $producto->id,
                'cantidad' => 1
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto añadido a la cesta correctamente'
        ]);
    }

    public function index()
    {
        // Requerir autenticación para ver el carrito
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tu cesta.');
        }

        // Cargar los items del carrito junto con su información de producto
        $items = Carrito::with('producto.imagenes')
                        ->where('id_usuario', Auth::id())
                        ->get();

        $totalPrice = 0;
        $totalItems = 0;
        foreach ($items as $item) {
            $totalPrice += $item->producto->precio * $item->cantidad;
            $totalItems += $item->cantidad;
        }

        return view('carrito.index', compact('items', 'totalPrice', 'totalItems'));
    }

    public function eliminar($id)
    {
        $item = Carrito::where('id', $id)->where('id_usuario', Auth::id())->first();
        if ($item) {
            $item->delete();
        }
        return back()->with('success', 'Producto eliminado de la cesta.');
    }

    /**
     * Actualizar la cantidad de un item del carrito (AJAX).
     */
    public function actualizarCantidad(Request $request, $id)
    {
        $item = Carrito::with('producto')
                       ->where('id', $id)
                       ->where('id_usuario', Auth::id())
                       ->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item no encontrado'], 404);
        }

        $nuevaCantidad = (int) $request->input('cantidad', 1);

        // Validar que la cantidad esté entre 1 y el stock disponible
        if ($nuevaCantidad < 1) {
            $nuevaCantidad = 1;
        }

        if ($nuevaCantidad > $item->producto->stock) {
            $nuevaCantidad = $item->producto->stock;
        }

        $item->cantidad = $nuevaCantidad;
        $item->save();

        // Recalcular totales
        $items = Carrito::with('producto')
                        ->where('id_usuario', Auth::id())
                        ->get();

        $totalPrice = 0;
        $totalItems = 0;
        foreach ($items as $carritoItem) {
            $totalPrice += $carritoItem->producto->precio * $carritoItem->cantidad;
            $totalItems += $carritoItem->cantidad;
        }

        return response()->json([
            'success' => true,
            'cantidad' => $nuevaCantidad,
            'subtotal' => number_format($item->producto->precio * $nuevaCantidad, 2),
            'totalPrice' => number_format($totalPrice, 2),
            'totalItems' => $totalItems
        ]);
    }

    /**
     * Pasar por caja: crear pedido, descontar stock, vaciar carrito.
     */
    public function checkout()
    {
        $userId = Auth::id();

        $items = Carrito::with('producto')
                        ->where('id_usuario', $userId)
                        ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Tu cesta está vacía.');
        }

        // Verificar stock antes de procesar
        foreach ($items as $item) {
            if ($item->cantidad > $item->producto->stock) {
                return back()->with('error', 'No hay suficiente stock de "' . $item->producto->nombre . '". Disponible: ' . $item->producto->stock);
            }
        }

        // Usar transacción para asegurar integridad
        DB::beginTransaction();

        try {
            // Calcular total
            $total = 0;
            foreach ($items as $item) {
                $total += $item->producto->precio * $item->cantidad;
            }

            // Crear pedido
            $pedido = Pedido::create([
                'estado' => 'pendiente',
                'total' => $total,
                'id_usuario' => $userId,
                'id_direcciones_envio' => null,
                'id_metodos_pago' => null
            ]);

            // Crear detalles del pedido y descontar stock
            foreach ($items as $item) {
                $detalle = DetallePedido::create([
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->producto->precio,
                    'id_pedido' => $pedido->id,
                    'id_producto' => $item->producto->id
                ]);

                // Descontar stock
                $item->producto->stock -= $item->cantidad;
                $item->producto->save();
            }

            // Vaciar carrito del usuario
            Carrito::where('id_usuario', $userId)->delete();

            DB::commit();

            return redirect()->route('pedidos.index')->with('success', '¡Pedido realizado con éxito! Total: ' . number_format($total, 2) . '€');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar el pedido. Inténtalo de nuevo.');
        }
    }
}
