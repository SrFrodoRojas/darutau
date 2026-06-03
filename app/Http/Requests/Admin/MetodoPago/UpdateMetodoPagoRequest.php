<?php

namespace App\Http\Requests\Admin\MetodoPago;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMetodoPagoRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->metodoPago);
    }

    public function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:30', Rule::unique('metodo_pago', 'nombre')->ignore($this->metodoPago)],
            'codigo' => ['required', 'string', 'max:20', Rule::unique('metodo_pago', 'codigo')->ignore($this->metodoPago)],
            'requiere_referencia' => 'boolean',
            'activo' => 'sometimes|boolean',
        ];
    }
}
