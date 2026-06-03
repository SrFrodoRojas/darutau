<?php

namespace App\Http\Requests\Admin\CategoriaMovimiento;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoriaMovimientoRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->categoriaMovimiento);
    }

    public function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:50', Rule::unique('categoria_movimiento', 'nombre')->ignore($this->categoriaMovimiento)],
            'tipo' => ['required', Rule::in(['ingreso', 'egreso'])],
            'activo' => 'sometimes|boolean',
        ];
    }
}
