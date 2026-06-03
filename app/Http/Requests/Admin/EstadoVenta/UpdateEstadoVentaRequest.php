<?php

namespace App\Http\Requests\Admin\EstadoVenta;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEstadoVentaRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->estadoVenta);
    }

    public function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:30', Rule::unique('estado_venta', 'nombre')->ignore($this->estadoVenta)],
            'orden' => 'nullable|integer',
        ];
    }
}
