<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EstadoVenta\StoreEstadoVentaRequest;
use App\Http\Requests\Admin\EstadoVenta\UpdateEstadoVentaRequest;
use App\Models\EstadoVenta;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EstadoVentaController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', EstadoVenta::class);
        return view('admin.estado-ventas.index');
    }

    public function data(Request $request)
    {
        $this->authorize('viewAny', EstadoVenta::class);
        $query = EstadoVenta::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nombre', 'like', "%{$search}%");
        }

        return DataTables::of($query)
            ->addColumn('acciones', function ($estado) {
                return view('admin.partials.acciones', [
                    'ver' => route('admin.estado-ventas.show', $estado),
                    'editar' => route('admin.estado-ventas.edit', $estado),
                    // No se muestra botón eliminar
                ])->render();
            })
            ->editColumn('orden', function ($estado) {
                return $estado->orden ?? '-';
            })
            ->rawColumns(['acciones'])
            ->make(true);
    }

    public function create()
    {
        $this->authorize('create', EstadoVenta::class);
        return view('admin.estado-ventas.create');
    }

    public function store(StoreEstadoVentaRequest $request)
    {
        $this->authorize('create', EstadoVenta::class);
        EstadoVenta::create($request->validated());
        return redirect()->route('admin.estado-ventas.index')->with('success', 'Estado de venta creado exitosamente.');
    }

    public function show(EstadoVenta $estadoVenta)
    {
        $this->authorize('view', $estadoVenta);
        return view('admin.estado-ventas.show', compact('estadoVenta'));
    }

    public function edit(EstadoVenta $estadoVenta)
    {
        $this->authorize('update', $estadoVenta);
        return view('admin.estado-ventas.edit', compact('estadoVenta'));
    }

    public function update(UpdateEstadoVentaRequest $request, EstadoVenta $estadoVenta)
    {
        $this->authorize('update', $estadoVenta);
        $estadoVenta->update($request->validated());
        return redirect()->route('admin.estado-ventas.index')->with('success', 'Estado de venta actualizado exitosamente.');
    }

    public function destroy($id)
    {
        abort(403, 'No se permite eliminar estados de venta.');
    }
}
