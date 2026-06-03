<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoriaMovimiento\StoreCategoriaMovimientoRequest;
use App\Http\Requests\Admin\CategoriaMovimiento\UpdateCategoriaMovimientoRequest;
use App\Models\CategoriaMovimiento;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoriaMovimientoController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', CategoriaMovimiento::class);
        return view('admin.categoria-movimientos.index');
    }

    public function data(Request $request)
    {
        $this->authorize('viewAny', CategoriaMovimiento::class);
        $query = CategoriaMovimiento::query();

        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nombre', 'like', "%{$search}%");
        }

        return DataTables::of($query)
            ->addColumn('acciones', function ($categoria) {
                return view('admin.partials.acciones', [
                    'ver' => route('admin.categoria-movimientos.show', $categoria),
                    'editar' => route('admin.categoria-movimientos.edit', $categoria),
                    'eliminar' => route('admin.categoria-movimientos.destroy', $categoria),
                ])->render();
            })
            ->editColumn('activo', function ($categoria) {
                return $categoria->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>';
            })
            ->editColumn('tipo', function ($categoria) {
                $badge = $categoria->tipo == 'ingreso' ? 'success' : 'warning';
                return '<span class="badge badge-'.$badge.'">'.ucfirst($categoria->tipo).'</span>';
            })
            ->rawColumns(['acciones', 'activo', 'tipo'])
            ->make(true);
    }

    public function create()
    {
        $this->authorize('create', CategoriaMovimiento::class);
        return view('admin.categoria-movimientos.create');
    }

    public function store(StoreCategoriaMovimientoRequest $request)
    {
        $this->authorize('create', CategoriaMovimiento::class);
        CategoriaMovimiento::create($request->validated());
        return redirect()->route('admin.categoria-movimientos.index')->with('success', 'Categoría de movimiento creada exitosamente.');
    }

    public function show(CategoriaMovimiento $categoriaMovimiento)
    {
        $this->authorize('view', $categoriaMovimiento);
        return view('admin.categoria-movimientos.show', compact('categoriaMovimiento'));
    }

    public function edit(CategoriaMovimiento $categoriaMovimiento)
    {
        $this->authorize('update', $categoriaMovimiento);
        return view('admin.categoria-movimientos.edit', compact('categoriaMovimiento'));
    }

    public function update(UpdateCategoriaMovimientoRequest $request, CategoriaMovimiento $categoriaMovimiento)
    {
        $this->authorize('update', $categoriaMovimiento);
        $categoriaMovimiento->update($request->validated());
        return redirect()->route('admin.categoria-movimientos.index')->with('success', 'Categoría de movimiento actualizada exitosamente.');
    }

    public function destroy(CategoriaMovimiento $categoriaMovimiento)
    {
        $this->authorize('delete', $categoriaMovimiento);
        $categoriaMovimiento->update(['activo' => false]);
        return redirect()->route('admin.categoria-movimientos.index')->with('success', 'Categoría de movimiento desactivada exitosamente.');
    }
}
