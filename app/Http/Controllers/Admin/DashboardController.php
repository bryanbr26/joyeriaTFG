<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'usuarios' => User::count(),
            'productos' => Producto::count(),
            'pedidos' => Pedido::count(),
            'itemsCarrito' => Carrito::sum('cantidad'),
            'stockBajo' => Producto::where('stock', '<=', 5)->count(),
            'ventas' => Pedido::sum('total'),
        ];

        $ultimosPedidos = Pedido::with('usuario')
            ->orderByDesc('fecha')
            ->limit(5)
            ->get();

        $productosStockBajo = Producto::orderBy('stock')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'ultimosPedidos', 'productosStockBajo'));
    }
}
