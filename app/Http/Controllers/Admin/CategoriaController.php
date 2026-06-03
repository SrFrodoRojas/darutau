<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categoria\StoreCategoriaRequest;
use App\Http\Requests\Admin\Categoria\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoriaController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Categoria::class);
        return view('admin.categorias.index');
    }

    public function data(Request $request)
    {
        $this->authorize('viewAny', Categoria::class);
        $query = Categoria::query();

        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addColumn('acciones', function ($categoria) {
                return view('admin.partials.acciones', [
                    'ver' => route('admin.categorias.show', $categoria),
                    'editar' => route('admin.categorias.edit', $categoria),
                    'eliminar' => route('admin.categorias.destroy', $categoria),
                ])->render();
            })
            ->editColumn('activo', function ($categoria) {
                return $categoria->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>';
            })
            ->rawColumns(['acciones', 'activo'])
            ->make(true);
    }

    public function create()
    {
        $this->authorize('create', Categoria::class);
        return view('admin.categorias.create');
    }

    public function store(StoreCategoriaRequest $request)
    {
        $this->authorize('create', Categoria::class);
        Categoria::create($request->validated());
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function show(Categoria $categoria)
    {
        $this->authorize('view', $categoria);
        return view('admin.categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        $this->authorize('update', $categoria);
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $this->authorize('update', $categoria);
        $categoria->update($request->validated());
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $this->authorize('delete', $categoria);
        $categoria->delete();
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
