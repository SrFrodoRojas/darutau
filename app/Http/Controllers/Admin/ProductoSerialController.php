<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductoSerial;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Http\Requests\Admin\ProductoSerial\StoreProductoSerialRequest;
use App\Http\Requests\Admin\ProductoSerial\UpdateProductoSerialRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductoSerialController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProductoSerial::class, 'producto_serial');
    }

    public function index()
    {
        return view('admin.seriales.index');
    }

    public function data()
    {
        $seriales = ProductoSerial::with(['producto', 'proveedor']);
        return DataTables::of($seriales)
            ->addColumn('acciones', function ($s) {
                return view('admin.partials.acciones', ['model' => $s, 'route' => 'seriales']);
            })
            ->editColumn('estado', function ($s) {
                $badges = ['disponible' => 'success', 'vendido' => 'danger', 'devuelto' => 'warning', 'en_reparacion' => 'info', 'dado_baja' => 'secondary'];
                return '<span class="badge badge-' . $badges[$s->estado] . '">' . ucfirst($s->estado) . '</span>';
            })
            ->rawColumns(['acciones', 'estado'])
            ->make(true);
    }

    public function create()
    {
        $productos = Producto::where('activo', true)->where('usa_serial', true)->get();
        $proveedores = Proveedor::where('activo', true)->get();
        return view('admin.seriales.create', compact('productos', 'proveedores'));
    }

    public function store(StoreProductoSerialRequest $request)
    {
        $data = $request->validated();
        $data['fecha_ingreso'] = $data['fecha_ingreso'] ?? now();
        ProductoSerial::create($data);
        return redirect()->route('admin.seriales.index')->with('success', 'Serial registrado.');
    }

    public function show(ProductoSerial $producto_serial)
    {
        $serial = $producto_serial;
        return view('admin.seriales.show', compact('serial'));
    }

    public function edit(ProductoSerial $producto_serial)
    {
        $productos = Producto::where('activo', true)->where('usa_serial', true)->get();
        $proveedores = Proveedor::where('activo', true)->get();
        return view('admin.seriales.edit', compact('producto_serial', 'productos', 'proveedores'));
    }

    public function update(UpdateProductoSerialRequest $request, ProductoSerial $producto_serial)
    {
        $producto_serial->update($request->validated());
        return redirect()->route('admin.seriales.index')->with('success', 'Serial actualizado.');
    }

    public function destroy(ProductoSerial $producto_serial)
    {
        $producto_serial->delete();
        return redirect()->route('admin.seriales.index')->with('success', 'Serial eliminado.');
    }
}
