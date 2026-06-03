<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposito;
use App\Models\Producto;
use App\Models\DepositoProducto;
use App\Models\StockMovimiento;
use App\Http\Requests\Admin\Stock\AjusteStockRequest;
use App\Services\StockService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
        $this->middleware('can:ajustarStock,App\Models\Producto')->only(['ajusteForm', 'ajusteStore']);
    }

    public function index(Request $request)
    {
        $depositos = Deposito::empresa()->get();
        $depositoId = $request->get('deposito_id', $depositos->first()->id ?? null);
        $stock = DepositoProducto::with(['producto', 'deposito'])
            ->when($depositoId, function ($q) use ($depositoId) {
                $q->where('deposito_id', $depositoId);
            })
            ->get();
        return view('admin.stock.index', compact('depositos', 'depositoId', 'stock'));
    }

    public function movimientos(Request $request)
    {
        $movimientos = StockMovimiento::with(['producto', 'deposito', 'usuario'])
            ->orderBy('created_at', 'desc');
        if ($request->ajax()) {
            return DataTables::of($movimientos)
                ->addColumn('producto_nombre', fn($m) => $m->producto->nombre)
                ->addColumn('deposito_nombre', fn($m) => $m->deposito->nombre)
                ->editColumn('cantidad', fn($m) => number_format($m->cantidad, 0))
                ->make(true);
        }
        return view('admin.stock.movimientos');
    }

    public function ajusteForm()
    {
        $productos = Producto::where('activo', true)->get();
        $depositos = Deposito::empresa()->get();
        return view('admin.stock.ajuste', compact('productos', 'depositos'));
    }

    public function ajusteStore(AjusteStockRequest $request)
    {
        $this->stockService->ajusteManual(
            $request->producto_id,
            $request->deposito_id,
            $request->cantidad,
            $request->motivo
        );
        return redirect()->route('admin.stock.index')->with('success', 'Ajuste de stock realizado.');
    }
}
