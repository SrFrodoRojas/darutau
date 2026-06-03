<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Marca\StoreMarcaRequest;
use App\Http\Requests\Admin\Marca\UpdateMarcaRequest;
use App\Models\Marca;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MarcaController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Marca::class);
        return view('admin.marcas.index');
    }

    public function data(Request $request)
    {
        $this->authorize('viewAny', Marca::class);
        $query = Marca::query();

        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addColumn('acciones', function ($marca) {
                return view('admin.partials.acciones', [
                    'ver' => route('admin.marcas.show', $marca),
                    'editar' => route('admin.marcas.edit', $marca),
                    'eliminar' => route('admin.marcas.destroy', $marca),
                ])->render();
            })
            ->editColumn('activo', function ($marca) {
                return $marca->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>';
            })
            ->rawColumns(['acciones', 'activo'])
            ->make(true);
    }

    public function create()
    {
        $this->authorize('create', Marca::class);
        return view('admin.marcas.create');
    }

    public function store(StoreMarcaRequest $request)
    {
        $this->authorize('create', Marca::class);
        Marca::create($request->validated());
        return redirect()->route('admin.marcas.index')->with('success', 'Marca creada exitosamente.');
    }

    public function show(Marca $marca)
    {
        $this->authorize('view', $marca);
        return view('admin.marcas.show', compact('marca'));
    }

    public function edit(Marca $marca)
    {
        $this->authorize('update', $marca);
        return view('admin.marcas.edit', compact('marca'));
    }

    public function update(UpdateMarcaRequest $request, Marca $marca)
    {
        $this->authorize('update', $marca);
        $marca->update($request->validated());
        return redirect()->route('admin.marcas.index')->with('success', 'Marca actualizada exitosamente.');
    }

    public function destroy(Marca $marca)
    {
        $this->authorize('delete', $marca);
        $marca->delete(); // Soft delete
        return redirect()->route('admin.marcas.index')->with('success', 'Marca eliminada exitosamente.');
    }
}
