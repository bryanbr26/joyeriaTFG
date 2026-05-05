<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\MetodoPago;
use App\Models\PagoRedsys;
use App\Services\RedsysService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{
    public function agregar(Request $request, Producto $producto)
    {
        // Requerir autenticación
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $userId = Auth::id();

        // Calcular el total de unidades de este producto en TODO el carrito
        // (incluye items normales + personalizados)
        $totalEnCarrito = Carrito::where('id_usuario', $userId)
                                ->where('id_producto', $producto->id)
                                ->sum('cantidad');

        // Verificar que hay stock para una unidad más
        if ($totalEnCarrito >= $producto->stock) {
            return response()->json([
                'success' => false,
                'message' => 'No hay más stock disponible de este producto (ya tienes ' . $totalEnCarrito . ' en la cesta)'
            ]);
        }

        // Buscar solo la entrada sin personalización para agrupar
        $carritoItem = Carrito::where('id_usuario', $userId)
                              ->where('id_producto', $producto->id)
                              ->whereNull('ruta_grabado_personalizado')
                              ->first();

        if ($carritoItem) {
            $carritoItem->cantidad += 1;
            $carritoItem->save();
        } else {
            Carrito::create([
                'id_usuario' => $userId,
                'id_producto' => $producto->id,
                'cantidad' => 1
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto añadido a la cesta correctamente',
            'totalItems' => Carrito::where('id_usuario', $userId)->sum('cantidad')
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

        // Calcular totales por producto para validar stock
        $unidadesPorProducto = $items->groupBy('id_producto')->map(function ($group) {
            return $group->sum('cantidad');
        });

        
        foreach ($items as $item) {
            $totalPrice += $item->producto->precio * $item->cantidad;
            $totalItems += $item->cantidad;

            // Máximo para esta línea = stock - unidades en OTRAS líneas
            $otrasUnidades = $unidadesPorProducto[$item->id_producto] - $item->cantidad;
            /** @var \App\Models\Carrito $item */
            //Metemos la linea anterior porque el intelliphense no reconoce la propiedad maxDisponible del modelo
            $item->maxDisponible = max(1, $item->producto->stock - $otrasUnidades);
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

        // Calcular cuántas unidades de este producto hay en OTRAS líneas del carrito
        $otrasUnidades = Carrito::where('id_usuario', Auth::id())
                               ->where('id_producto', $item->producto->id)
                               ->where('id', '!=', $item->id)
                               ->sum('cantidad');

        // El máximo para esta línea es: stock total - unidades en otras líneas
        $maxParaEstaLinea = $item->producto->stock - $otrasUnidades;
        if ($maxParaEstaLinea < 1) $maxParaEstaLinea = 1;

        // Validar que la cantidad esté entre 1 y el máximo disponible
        if ($nuevaCantidad < 1) {
            $nuevaCantidad = 1;
        }

        if ($nuevaCantidad > $maxParaEstaLinea) {
            $nuevaCantidad = $maxParaEstaLinea;
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

        // Recalcular máximos para TODAS las líneas del mismo producto
        $itemsMismoProducto = $items->where('id_producto', $item->producto->id);
        $totalProducto = $itemsMismoProducto->sum('cantidad');
        $stockProducto = $item->producto->stock;

        $itemsActualizados = [];
        foreach ($itemsMismoProducto as $linea) {
            $otrasUds = $totalProducto - $linea->cantidad;
            $maxLinea = max(1, $stockProducto - $otrasUds);
            $itemsActualizados[] = [
                'id' => $linea->id,
                'cantidad' => $linea->cantidad,
                'maxDisponible' => $maxLinea
            ];
        }

        return response()->json([
            'success' => true,
            'cantidad' => $nuevaCantidad,
            'subtotal' => number_format($item->producto->precio * $nuevaCantidad, 2),
            'totalPrice' => number_format($totalPrice, 2),
            'totalItems' => $totalItems,
            'itemsActualizados' => $itemsActualizados
        ]);
    }

    /**
     * Pasar por caja: crear pedido pendiente y redirigir a Redsys.
     */
    public function checkout(RedsysService $redsys)
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

        try {
            $formData = DB::transaction(function () use ($userId, $redsys) {
                $items = Carrito::with('producto')
                    ->where('id_usuario', $userId)
                    ->lockForUpdate()
                    ->get();

                if ($items->isEmpty()) {
                    throw new \RuntimeException('Tu cesta está vacía.');
                }

                $productIds = $items->pluck('id_producto')->unique()->values();
                $productos = Producto::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');
                $unidadesPorProducto = $items->groupBy('id_producto')->map(function ($group) {
                    return $group->sum('cantidad');
                });

                foreach ($unidadesPorProducto as $productoId => $cantidad) {
                    $producto = $productos->get($productoId);

                    if (!$producto || $cantidad > $producto->stock) {
                        $nombre = $producto ? $producto->nombre : 'un producto de tu cesta';
                        $stock = $producto ? $producto->stock : 0;

                        throw new \RuntimeException('No hay suficiente stock de "' . $nombre . '". Disponible: ' . $stock);
                    }
                }

                $total = 0;
                foreach ($items as $item) {
                    $producto = $productos->get($item->id_producto);
                    $total += $producto->precio * $item->cantidad;
                }

                $metodoPago = MetodoPago::firstOrCreate(
                    ['nombre' => 'Redsys'],
                    ['descripcion' => 'Pago seguro con tarjeta mediante TPV Virtual Redsys']
                );

                $pedido = Pedido::create([
                    'estado' => 'pendiente',
                    'total' => $total,
                    'id_usuario' => $userId,
                    'id_direcciones_envio' => null,
                    'id_metodos_pago' => $metodoPago->id
                ]);

                foreach ($items as $item) {
                    $producto = $productos->get($item->id_producto);

                    DetallePedido::create([
                        'cantidad' => $item->cantidad,
                        'precio_unitario' => $producto->precio,
                        'id_pedido' => $pedido->id,
                        'id_producto' => $producto->id,
                        'ruta_grabado_personalizado' => $item->ruta_grabado_personalizado
                    ]);

                    $producto->stock -= $item->cantidad;
                    $producto->save();
                }

                $pago = PagoRedsys::create([
                    'importe' => $total,
                    'estado' => 'pendiente',
                    'id_pedido' => $pedido->id,
                    'numero_pedido_redsys' => $redsys->createOrderNumber($pedido->id),
                    'respuesta_json' => [
                        'environment' => config('redsys.environment'),
                        'created_from' => 'checkout',
                    ],
                ]);

                Carrito::where('id_usuario', $userId)->delete();

                return $redsys->buildPaymentForm($pedido->load('usuario'), $pago);
            });

            return view('redsys.redirect', compact('formData'));
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Error iniciando pago Redsys.', [
                'user_id' => $userId,
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Error al iniciar el pago seguro. Inténtalo de nuevo.');
        }
    }
}
