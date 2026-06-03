<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Impuesto\StoreImpuestoRequest;
use App\Http\Requests\Admin\Impuesto\UpdateImpuestoRequest;
use App\Models\Impuesto;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ImpuestoController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Impuesto::class);
        return view('admin.impuestos.index');
    }

    public function data(Request $request)
    {
        $this->authorize('viewAny', Impuesto::class);
        $query = Impuesto::query();

        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('porcentaje', 'like', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addColumn('acciones', function ($impuesto) {
                return view('admin.partials.acciones', [
                    'ver' => route('admin.impuestos.show', $impuesto),
                    'editar' => route('admin.impuestos.edit', $impuesto),
                    'eliminar' => route('admin.impuestos.destroy', $impuesto),
                ])->render();
            })
            ->editColumn('activo', function ($impuesto) {
                return $impuesto->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>';
            })
            ->editColumn('porcentaje', function ($impuesto) {
                return number_format($impuesto->porcentaje, 2) . '%';
            })
            ->rawColumns(['acciones', 'activo'])
            ->make(true);
    }

    public function create()
    {
        $this->authorize('create', Impuesto::class);
        return view('admin.impuestos.create');
    }

    public function store(StoreImpuestoRequest $request)
    {
        $this->authorize('create', Impuesto::class);
        Impuesto::create($request->validated());
        return redirect()->route('admin.impuestos.index')->with('success', 'Impuesto creado exitosamente.');
    }

    public function show(Impuesto $impuesto)
    {
        $this->authorize('view', $impuesto);
        return view('admin.impuestos.show', compact('impuesto'));
    }

    public function edit(Impuesto $impuesto)
    {
        $this->authorize('update', $impuesto);
        return view('admin.impuestos.edit', compact('impuesto'));
    }

    public function update(UpdateImpuestoRequest $request, Impuesto $impuesto)
    {
        $this->authorize('update', $impuesto);
        $impuesto->update($request->validated());
        return redirect()->route('admin.impuestos.index')->with('success', 'Impuesto actualizado exitosamente.');
    }

    public function destroy(Impuesto $impuesto)
    {
        $this->authorize('delete', $impuesto);
        // No se elimina físicamente, solo se desactiva
        $impuesto->update(['activo' => false]);
        return redirect()->route('admin.impuestos.index')->with('success', 'Impuesto desactivado exitosamente.');
    }
}
