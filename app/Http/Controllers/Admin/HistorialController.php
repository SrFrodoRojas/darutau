<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrecioHistorial;
use App\Models\CostoHistorial;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HistorialController extends Controller
{
    public function precios(Request $request)
    {
        if ($request->ajax()) {
            $historial = PrecioHistorial::with(['producto', 'usuario'])->orderBy('created_at', 'desc');
            return DataTables::of($historial)
                ->addColumn('producto_nombre', fn($h) => $h->producto->nombre)
                ->addColumn('usuario_nombre', fn($h) => $h->usuario->name ?? 'Sistema')
                ->editColumn('precio_anterior', fn($h) => number_format($h->precio_anterior, 0))
                ->editColumn('precio_nuevo', fn($h) => number_format($h->precio_nuevo, 0))
                ->make(true);
        }
        return view('admin.historial.precios');
    }

    public function costos(Request $request)
    {
        if ($request->ajax()) {
            $historial = CostoHistorial::with(['producto', 'usuario'])->orderBy('created_at', 'desc');
            return DataTables::of($historial)
                ->addColumn('producto_nombre', fn($h) => $h->producto->nombre)
                ->addColumn('usuario_nombre', fn($h) => $h->usuario->name ?? 'Sistema')
                ->editColumn('costo_anterior', fn($h) => number_format($h->costo_anterior, 0))
                ->editColumn('costo_nuevo', fn($h) => number_format($h->costo_nuevo, 0))
                ->make(true);
        }
        return view('admin.historial.costos');
    }
}
