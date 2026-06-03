<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProveedorPago\StoreProveedorPagoRequest;
use App\Models\ProveedorPago;
use App\Services\CreditoProveedorService;
use Illuminate\Support\Facades\DB;

class ProveedorPagoController extends Controller
{
    protected CreditoProveedorService $creditoService;

    public function __construct(CreditoProveedorService $creditoService)
    {
        $this->creditoService = $creditoService;
    }

    public function index()
    {
        $this->authorize('makePayment', ProveedorPago::class);
        return view('admin.proveedores.pagos.index');
    }

    public function data()
    {
        $this->authorize('makePayment', ProveedorPago::class);
        $pagos = ProveedorPago::with(['proveedor', 'metodoPago', 'caja', 'creador'])
            ->select('proveedor_pago.*');
        return DataTables::of($pagos)
            ->addColumn('action', 'admin.proveedores.pagos.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $this->authorize('makePayment', ProveedorPago::class);
        $proveedores = Proveedor::orderBy('nombre')->get();
        $cajas = auth()->user()->cajas()->where('estado', 'abierta')->get();
        return view('admin.proveedores.pagos.create', compact('proveedores', 'cajas'));
    }

    public function store(StoreProveedorPagoRequest $request)
    {
        $this->authorize('makePayment', ProveedorPago::class);
        $caja = \App\Models\Caja::findOrFail($request->caja_id);
        $usuario = auth()->user();

        DB::transaction(function () use ($request, $caja, $usuario) {
            $pago = ProveedorPago::create([
                'proveedor_id' => $request->proveedor_id,
                'monto' => $request->monto,
                'metodo_pago_id' => $request->metodo_pago_id,
                'referencia' => $request->referencia,
                'caja_id' => $request->caja_id,
                'created_by' => $usuario->id,
                'created_at' => now(),
            ]);
            $this->creditoService->registrarPago($pago, $caja, $usuario);
        });

        return redirect()->route('admin.proveedores.pagos.index')
            ->with('success', 'Pago a proveedor registrado.');
    }

    public function show(ProveedorPago $pago)
    {
        $this->authorize('view', $pago);
        return view('admin.proveedores.pagos.show', compact('pago'));
    }
}
