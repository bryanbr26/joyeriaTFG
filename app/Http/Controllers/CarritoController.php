<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            // Si ya existe, incrementar la cantidad
            $carritoItem->cantidad += 1;
            $carritoItem->save();
        } else {
            // Si no existe, crear un nuevo registro
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
}
