<?php

namespace App\Http\Requests\Admin\EstadoVenta;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstadoVentaRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', \App\Models\EstadoVenta::class);
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:30|unique:estado_venta,nombre',
            'orden' => 'nullable|integer',
        ];
    }
}
