<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $periodo = $request->input('periodo', 'mes');
        if (!in_array($periodo, ['mes', 'anio', 'todo'])) {
            $periodo = 'mes';
        }

        $anio = (int) $request->input('anio', now()->year);
        $mes = (int) $request->input('mes', now()->month);
        $mes = min(max($mes, 1), 12);

        [$fechaInicio, $fechaFin, $periodoLabel] = $this->resolvePeriodo($periodo, $anio, $mes);

        $pedidosPeriodo = Pedido::query();
        if ($fechaInicio && $fechaFin) {
            $pedidosPeriodo->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        $detallesPeriodo = DetallePedido::query()
            ->join('PEDIDO', 'DETALLES_PEDIDO.id_pedido', '=', 'PEDIDO.id');

        if ($fechaInicio && $fechaFin) {
            $detallesPeriodo->whereBetween('PEDIDO.fecha', [$fechaInicio, $fechaFin]);
        }

        $productosPeriodo = Producto::query();
        if ($fechaInicio && $fechaFin) {
            $productosPeriodo->whereBetween('fecha_agregado', [$fechaInicio, $fechaFin]);
        }

        $productoMasVendido = (clone $detallesPeriodo)
            ->leftJoin('PRODUCTO', 'DETALLES_PEDIDO.id_producto', '=', 'PRODUCTO.id')
            ->select(
                'DETALLES_PEDIDO.id_producto',
                DB::raw("COALESCE(PRODUCTO.nombre, 'Producto eliminado') as nombre"),
                DB::raw('SUM(DETALLES_PEDIDO.cantidad) as unidades')
            )
            ->groupBy('DETALLES_PEDIDO.id_producto', 'PRODUCTO.nombre')
            ->orderByDesc('unidades')
            ->first();

        $stats = [
            'usuarios' => User::count(),
            'productos' => (clone $productosPeriodo)->count(),
            'pedidos' => (clone $pedidosPeriodo)->count(),
            'unidadesVendidas' => (clone $detallesPeriodo)->sum('DETALLES_PEDIDO.cantidad'),
            'productoMasVendido' => $productoMasVendido,
            'stockBajo' => Producto::where('stock', '<=', 5)->count(),
            'ventas' => (clone $pedidosPeriodo)->sum('total'),
        ];

        $ultimosPedidos = Pedido::with('usuario')
            ->when($fechaInicio && $fechaFin, function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
            })
            ->orderByDesc('fecha')
            ->limit(5)
            ->get();

        $productosMasVendidos = (clone $detallesPeriodo)
            ->leftJoin('PRODUCTO', 'DETALLES_PEDIDO.id_producto', '=', 'PRODUCTO.id')
            ->select(
                'DETALLES_PEDIDO.id_producto',
                DB::raw("COALESCE(PRODUCTO.nombre, 'Producto eliminado') as nombre"),
                DB::raw("COALESCE(PRODUCTO.categoria, '-') as categoria"),
                DB::raw('SUM(DETALLES_PEDIDO.cantidad) as unidades'),
                DB::raw('SUM(DETALLES_PEDIDO.precio_unitario * DETALLES_PEDIDO.cantidad) as total')
            )
            ->groupBy('DETALLES_PEDIDO.id_producto', 'PRODUCTO.nombre', 'PRODUCTO.categoria')
            ->orderByDesc('unidades')
            ->limit(5)
            ->get();

        $productosStockBajo = Producto::orderBy('stock')
            ->limit(5)
            ->get();

        $aniosDisponibles = Pedido::selectRaw('YEAR(fecha) as anio')
            ->whereNotNull('fecha')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        if ($aniosDisponibles->isEmpty()) {
            $aniosDisponibles = collect([now()->year]);
        }

        $filtros = compact('periodo', 'anio', 'mes', 'periodoLabel', 'aniosDisponibles');

        return view('admin.dashboard', compact('stats', 'ultimosPedidos', 'productosStockBajo', 'productosMasVendidos', 'filtros'));
    }

    private function resolvePeriodo(string $periodo, int $anio, int $mes): array
    {
        if ($periodo === 'todo') {
            return [null, null, 'Histórico completo'];
        }

        if ($periodo === 'anio') {
            $inicio = Carbon::create($anio, 1, 1)->startOfDay();
            $fin = Carbon::create($anio, 12, 31)->endOfDay();

            return [$inicio, $fin, 'Año ' . $anio];
        }

        $inicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fin = (clone $inicio)->endOfMonth();

        return [$inicio, $fin, ucfirst($inicio->locale('es')->translatedFormat('F Y'))];
    }
}
