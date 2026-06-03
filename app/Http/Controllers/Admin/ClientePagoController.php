<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientePago\StoreClientePagoRequest;
use App\Models\Cliente;
use App\Models\ClientePago;
use App\Services\CreditoClienteService;
use Illuminate\Http\Request;

class ClientePagoController extends Controller
{
    protected CreditoClienteService $creditoService;

    public function __construct(CreditoClienteService $creditoService)
    {
        $this->creditoService = $creditoService;
    }

    public function index()
    {
        $this->authorize('makePayment', ClientePago::class);
        return view('admin.clientes.pagos.index');
    }

    public function data()
    {
        $this->authorize('makePayment', ClientePago::class);
        $pagos = ClientePago::with(['cliente', 'metodoPago', 'caja', 'creador'])
            ->select('cliente_pago.*');
        return DataTables::of($pagos)
            ->addColumn('action', 'admin.clientes.pagos.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $this->authorize('makePayment', ClientePago::class);
        $clientes = Cliente::orderBy('nombre')->get();
        $cajas = auth()->user()->cajas()->where('estado', 'abierta')->get();
        return view('admin.clientes.pagos.create', compact('clientes', 'cajas'));
    }

    public function store(StoreClientePagoRequest $request)
    {
        $this->authorize('makePayment', ClientePago::class);
        $caja = \App\Models\Caja::findOrFail($request->caja_id);
        $usuario = auth()->user();

        DB::transaction(function () use ($request, $caja, $usuario) {
            $pago = ClientePago::create([
                'cliente_id' => $request->cliente_id,
                'monto' => $request->monto,
                'metodo_pago_id' => $request->metodo_pago_id,
                'referencia' => $request->referencia,
                'caja_id' => $request->caja_id,
                'created_by' => $usuario->id,
                'created_at' => now(),
            ]);
            $this->creditoService->registrarPago($pago, $caja, $usuario);
        });

        return redirect()->route('admin.clientes.pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    public function show(ClientePago $pago)
    {
        $this->authorize('view', $pago);
        return view('admin.clientes.pagos.show', compact('pago'));
    }
}
