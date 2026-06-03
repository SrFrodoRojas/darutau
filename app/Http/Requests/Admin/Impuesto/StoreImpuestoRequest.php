<?php

namespace App\Http\Requests\Admin\Impuesto;

use Illuminate\Foundation\Http\FormRequest;

class StoreImpuestoRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', \App\Models\Impuesto::class);
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:50|unique:impuesto,nombre',
            'porcentaje' => 'required|numeric|between:0,100',
            'activo' => 'sometimes|boolean',
        ];
    }
}
