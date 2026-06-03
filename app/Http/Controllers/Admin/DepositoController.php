<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposito;
use App\Http\Requests\Admin\Deposito\StoreDepositoRequest;
use App\Http\Requests\Admin\Deposito\UpdateDepositoRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepositoController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Deposito::class, 'deposito');
    }

    public function index()
    {
        return view('admin.depositos.index');
    }

    public function data()
    {
        $depositos = Deposito::empresa()->with('responsable');
        return DataTables::of($depositos)
            ->addColumn('acciones', function ($dep) {
                return view('admin.partials.acciones', ['model' => $dep, 'route' => 'depositos']);
            })
            ->editColumn('activo', function ($dep) {
                return $dep->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>';
            })
            ->rawColumns(['acciones', 'activo'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.depositos.create');
    }

    public function store(StoreDepositoRequest $request)
    {
        $data = $request->validated();
        $data['empresa_id'] = session('empresa_id');
        Deposito::create($data);
        return redirect()->route('admin.depositos.index')->with('success', 'Depósito creado correctamente.');
    }

    public function show(Deposito $deposito)
    {
        return view('admin.depositos.show', compact('deposito'));
    }

    public function edit(Deposito $deposito)
    {
        return view('admin.depositos.edit', compact('deposito'));
    }

    public function update(UpdateDepositoRequest $request, Deposito $deposito)
    {
        $deposito->update($request->validated());
        return redirect()->route('admin.depositos.index')->with('success', 'Depósito actualizado.');
    }

    public function destroy(Deposito $deposito)
    {
        $deposito->delete();
        return redirect()->route('admin.depositos.index')->with('success', 'Depósito eliminado.');
    }
}
