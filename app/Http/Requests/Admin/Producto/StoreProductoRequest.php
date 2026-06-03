<?php

namespace App\Http\Requests\Admin\Producto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigo' => 'nullable|string|max:50|unique:producto,codigo',
            'codigo_barras' => 'nullable|string|max:50|unique:producto,codigo_barras',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'referencia' => 'nullable|string|max:50',
            'precio_compra' => 'nullable|integer|min:0',
            'precio_venta' => 'required|integer|min:0',
            'unidad_medida' => 'nullable|string|max:20',
            'peso_gramos' => 'nullable|integer|min:0',
            'dimensiones' => 'nullable|string|max:50',
            'categoria_id' => 'nullable|exists:categoria,id',
            'marca_id' => 'nullable|exists:marca,id',
            'activo' => 'boolean',
            'destacado' => 'boolean',
            'usa_serial' => 'boolean',
            'mostrar_web' => 'boolean',
            'precio_incluye_iva' => 'boolean',
            'impuesto_id' => 'nullable|exists:impuesto,id',
        ];
    }
}
