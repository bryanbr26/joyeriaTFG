<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    /**
     * Muestra la lista de favoritos del usuario logueado.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tus favoritos.');
        }

        $favoritos = Favorito::with('producto.imagenes')
                             ->where('id_usuario', Auth::id())
                             ->get();

        return view('favoritos.index', compact('favoritos'));
    }

    /**
     * Añade o elimina un producto de favoritos (toggle).
     * Devuelve JSON para peticiones AJAX.
     */
    public function toggle(Request $request, Producto $producto)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $userId = Auth::id();

        $favorito = Favorito::where('id_usuario', $userId)
                            ->where('id_producto', $producto->id)
                            ->first();

        if ($favorito) {
            // Ya existe → eliminar
            $favorito->delete();
            return response()->json([
                'success' => true,
                'favorito' => false,
                'message' => 'Producto eliminado de favoritos'
            ]);
        } else {
            // No existe → añadir
            Favorito::create([
                'id_usuario' => $userId,
                'id_producto' => $producto->id
            ]);
            return response()->json([
                'success' => true,
                'favorito' => true,
                'message' => 'Producto añadido a favoritos'
            ]);
        }
    }

    /**
     * Elimina un favorito por su ID (desde la página de favoritos).
     */
    public function eliminar($id)
    {
        $item = Favorito::where('id', $id)->where('id_usuario', Auth::id())->first();
        if ($item) {
            $item->delete();
        }
        return back()->with('success', 'Producto eliminado de favoritos.');
    }

    /**
     * Añade un producto de favoritos al carrito y opcionalmente lo elimina de favoritos.
     */
    public function agregarAlCarrito(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $favorito = Favorito::where('id', $id)->where('id_usuario', Auth::id())->first();

        if (!$favorito) {
            return back()->with('error', 'Favorito no encontrado.');
        }

        $userId = Auth::id();
        $productoId = $favorito->id_producto;

        // Comprobar si el producto ya está en el carrito del usuario
        $carritoItem = Carrito::where('id_usuario', $userId)
                              ->where('id_producto', $productoId)
                              ->first();

        if ($carritoItem) {
            $carritoItem->cantidad += 1;
            $carritoItem->save();
        } else {
            Carrito::create([
                'id_usuario' => $userId,
                'id_producto' => $productoId,
                'cantidad' => 1
            ]);
        }

        return back()->with('success', 'Producto añadido a la cesta.');
    }
}
