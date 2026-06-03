<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MetodoPago\StoreMetodoPagoRequest;
use App\Http\Requests\Admin\MetodoPago\UpdateMetodoPagoRequest;
use App\Models\MetodoPago;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', MetodoPago::class);
        return view('admin.metodo-pagos.index');
    }

    public function data(Request $request)
    {
        $this->authorize('viewAny', MetodoPago::class);
        $query = MetodoPago::query();

        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }
        if ($request->filled('requiere_referencia')) {
            $query->where('requiere_referencia', $request->requiere_referencia);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addColumn('acciones', function ($metodo) {
                return view('admin.partials.acciones', [
                    'ver' => route('admin.metodo-pagos.show', $metodo),
                    'editar' => route('admin.metodo-pagos.edit', $metodo),
                    'eliminar' => route('admin.metodo-pagos.destroy', $metodo),
                ])->render();
            })
            ->editColumn('activo', function ($metodo) {
                return $metodo->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>';
            })
            ->editColumn('requiere_referencia', function ($metodo) {
                return $metodo->requiere_referencia ? '<span class="badge badge-info">Sí</span>' : '<span class="badge badge-secondary">No</span>';
            })
            ->rawColumns(['acciones', 'activo', 'requiere_referencia'])
            ->make(true);
    }

    public function create()
    {
        $this->authorize('create', MetodoPago::class);
        return view('admin.metodo-pagos.create');
    }

    public function store(StoreMetodoPagoRequest $request)
    {
        $this->authorize('create', MetodoPago::class);
        MetodoPago::create($request->validated());
        return redirect()->route('admin.metodo-pagos.index')->with('success', 'Método de pago creado exitosamente.');
    }

    public function show(MetodoPago $metodoPago)
    {
        $this->authorize('view', $metodoPago);
        return view('admin.metodo-pagos.show', compact('metodoPago'));
    }

    public function edit(MetodoPago $metodoPago)
    {
        $this->authorize('update', $metodoPago);
        return view('admin.metodo-pagos.edit', compact('metodoPago'));
    }

    public function update(UpdateMetodoPagoRequest $request, MetodoPago $metodoPago)
    {
        $this->authorize('update', $metodoPago);
        $metodoPago->update($request->validated());
        return redirect()->route('admin.metodo-pagos.index')->with('success', 'Método de pago actualizado exitosamente.');
    }

    public function destroy(MetodoPago $metodoPago)
    {
        $this->authorize('delete', $metodoPago);
        $metodoPago->update(['activo' => false]);
        return redirect()->route('admin.metodo-pagos.index')->with('success', 'Método de pago desactivado exitosamente.');
    }
}
