<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proveedor\StoreProveedorRequest;
use App\Http\Requests\Proveedor\UpdateProveedorRequest;
use App\Models\Proveedor;
use Yajra\DataTables\Facades\DataTables;

class ProveedorController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Proveedor::class);
        return view('admin.proveedores.index');
    }

    public function data()
    {
        $this->authorize('viewAny', Proveedor::class);
        $proveedores = Proveedor::with('credito')->select('proveedor.*');
        return DataTables::of($proveedores)
            ->addColumn('saldo', fn($p) => number_format($p->saldo_credito, 0, ',', '.'))
            ->addColumn('limite', fn($p) => number_format($p->limite_credito, 0, ',', '.'))
            ->addColumn('disponible', fn($p) => number_format($p->saldo_disponible, 0, ',', '.'))
            ->addColumn('action', 'admin.proveedores.partials.actions')
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $this->authorize('create', Proveedor::class);
        return view('admin.proveedores.create');
    }

    public function store(StoreProveedorRequest $request)
    {
        $this->authorize('create', Proveedor::class);
        Proveedor::create($request->validated());
        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor creado.');
    }

    public function show(Proveedor $proveedor)
    {
        $this->authorize('view', $proveedor);
        $movimientos = $proveedor->movimientosCredito()->latest('created_at')->paginate(20);
        $pagos = $proveedor->pagos()->latest('created_at')->paginate(20);
        return view('admin.proveedores.show', compact('proveedor', 'movimientos', 'pagos'));
    }

    public function edit(Proveedor $proveedor)
    {
        $this->authorize('update', $proveedor);
        return view('admin.proveedores.edit', compact('proveedor'));
    }

    public function update(UpdateProveedorRequest $request, Proveedor $proveedor)
    {
        $this->authorize('update', $proveedor);
        $proveedor->update($request->validated());
        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor actualizado.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $this->authorize('delete', $proveedor);
        $proveedor->delete();
        return response()->json(['success' => true]);
    }
}
