<?php

namespace App\Http\Requests\Admin\Impuesto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateImpuestoRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->impuesto);
    }

    public function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:50', Rule::unique('impuesto', 'nombre')->ignore($this->impuesto)],
            'porcentaje' => 'required|numeric|between:0,100',
            'activo' => 'sometimes|boolean',
        ];
    }
}
