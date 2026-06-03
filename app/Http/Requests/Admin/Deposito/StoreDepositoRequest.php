<?php

namespace App\Http\Requests\Admin\Deposito;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepositoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Policy se aplica en controlador
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'nullable|string',
            'responsable_id' => 'nullable|exists:usuario,id',
            'activo' => 'boolean',
        ];
    }
}
