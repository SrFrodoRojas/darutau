<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\StoreClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClienteController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Cliente::class);
        return view('admin.clientes.index');
    }

    public function data()
    {
        $this->authorize('viewAny', Cliente::class);
        $clientes = Cliente::with('credito')->select('cliente.*');
        return DataTables::of($clientes)
            ->addColumn('saldo', function ($cliente) {
                return number_format($cliente->saldo_credito, 0, ',', '.');
            })
            ->addColumn('limite', function ($cliente) {
                return number_format($cliente->limite_credito, 0, ',', '.');
            })
            ->addColumn('disponible', function ($cliente) {
                return number_format($cliente->saldo_disponible, 0, ',', '.');
            })
            ->addColumn('action', 'admin.clientes.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $this->authorize('create', Cliente::class);
        return view('admin.clientes.create');
    }

    public function store(StoreClienteRequest $request)
    {
        $this->authorize('create', Cliente::class);
        $cliente = Cliente::create($request->validated());
        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        $this->authorize('view', $cliente);
        $movimientos = $cliente->movimientosCredito()->latest('created_at')->paginate(20);
        $pagos = $cliente->pagos()->latest('created_at')->paginate(20);
        return view('admin.clientes.show', compact('cliente', 'movimientos', 'pagos'));
    }

    public function edit(Cliente $cliente)
    {
        $this->authorize('update', $cliente);
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $this->authorize('update', $cliente);
        $cliente->update($request->validated());
        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente actualizado.');
    }

    public function destroy(Cliente $cliente)
    {
        $this->authorize('delete', $cliente);
        $cliente->delete();
        return response()->json(['success' => true]);
    }

    public function restore($id)
    {
        $cliente = Cliente::withTrashed()->findOrFail($id);
        $this->authorize('restore', $cliente);
        $cliente->restore();
        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente restaurado.');
    }

    public function forceDelete($id)
    {
        $cliente = Cliente::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $cliente);
        $cliente->forceDelete();
        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente eliminado permanentemente.');
    }
}
