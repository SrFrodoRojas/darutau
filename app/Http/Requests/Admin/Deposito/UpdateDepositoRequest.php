<?php

namespace App\Http\Requests\Admin\Deposito;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepositoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('deposito');
        return [
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'nullable|string',
            'responsable_id' => 'nullable|exists:usuario,id',
            'activo' => 'boolean',
        ];
    }
}
