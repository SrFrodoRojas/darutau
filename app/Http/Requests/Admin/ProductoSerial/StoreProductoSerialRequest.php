<?php

namespace App\Http\Requests\Admin\ProductoSerial;

use App\Rules\ProductoConSerial;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductoSerialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'producto_id' => ['required', 'exists:producto,id', new ProductoConSerial],
            'serial' => 'required|string|max:100|unique:producto_serial,serial',
            'estado' => 'required|in:disponible,vendido,devuelto,en_reparacion,dado_baja',
            'fecha_ingreso' => 'nullable|date',
            'fecha_vencimiento_garantia' => 'nullable|date|after_or_equal:fecha_ingreso',
            'proveedor_id' => 'nullable|exists:proveedor,id',
            'notas' => 'nullable|string',
        ];
    }
}
