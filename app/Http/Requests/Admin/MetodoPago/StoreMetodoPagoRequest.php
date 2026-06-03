<?php

namespace App\Http\Requests\Admin\MetodoPago;

use Illuminate\Foundation\Http\FormRequest;

class StoreMetodoPagoRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', \App\Models\MetodoPago::class);
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:30|unique:metodo_pago,nombre',
            'codigo' => 'required|string|max:20|unique:metodo_pago,codigo',
            'requiere_referencia' => 'boolean',
            'activo' => 'sometimes|boolean',
        ];
    }
}
