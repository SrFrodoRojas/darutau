<?php

namespace App\Http\Requests\Admin\CategoriaMovimiento;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoriaMovimientoRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', \App\Models\CategoriaMovimiento::class);
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:50|unique:categoria_movimiento,nombre',
            'tipo' => ['required', Rule::in(['ingreso', 'egreso'])],
            'activo' => 'sometimes|boolean',
        ];
    }
}
