<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Impuesto;
use App\Models\Deposito;
use App\Http\Requests\Admin\Producto\StoreProductoRequest;
use App\Http\Requests\Admin\Producto\UpdateProductoRequest;
use App\Services\PrecioService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{
    protected $precioService;

    public function __construct(PrecioService $precioService)
    {
        $this->precioService = $precioService;
        $this->authorizeResource(Producto::class, 'producto');
    }

    public function index()
    {
        return view('admin.productos.index');
    }

    public function data()
    {
        $productos = Producto::with(['categoria', 'marca']);
        return DataTables::of($productos)
            ->addColumn('acciones', function ($prod) {
                return view('admin.partials.acciones', ['model' => $prod, 'route' => 'productos']);
            })
            ->editColumn('activo', function ($prod) {
                return $prod->activo ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
            })
            ->addColumn('precio_venta', function ($prod) {
                return number_format($prod->precio_venta, 0, ',', '.');
            })
            ->rawColumns(['acciones', 'activo'])
            ->make(true);
    }

    public function create()
    {
        $categorias = Categoria::where('activo', true)->get();
        $marcas = Marca::where('activo', true)->get();
        $impuestos = Impuesto::where('activo', true)->get();
        return view('admin.productos.create', compact('categorias', 'marcas', 'impuestos'));
    }

    public function store(StoreProductoRequest $request)
    {
        $data = $request->validated();
        $data['empresa_id'] = session('empresa_id');
        $producto = Producto::create($data);
        return redirect()->route('admin.productos.index')->with('success', 'Producto creado.');
    }

    public function show(Producto $producto)
    {
        $depositos = Deposito::empresa()->get();
        $stockPorDeposito = $producto->depositoProductos()->with('deposito')->get();
        return view('admin.productos.show', compact('producto', 'depositos', 'stockPorDeposito'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::where('activo', true)->get();
        $marcas = Marca::where('activo', true)->get();
        $impuestos = Impuesto::where('activo', true)->get();
        return view('admin.productos.edit', compact('producto', 'categorias', 'marcas', 'impuestos'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $data = $request->validated();
        // Si cambia el precio de venta, usar servicio
        if (isset($data['precio_venta']) && $data['precio_venta'] != $producto->precio_venta) {
            $this->precioService->actualizarPrecioVenta($producto->id, $data['precio_venta']);
        }
        $producto->update($data);
        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado.');
    }
}
