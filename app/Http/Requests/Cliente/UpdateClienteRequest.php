<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $cliente = $this->route('cliente');
        return auth()->user()->can('update', $cliente);
    }

    public function rules(): array
    {
        $cliente = $this->route('cliente');
        return [
            'nombre' => 'required|string|max:100',
            'ruc_ci' => 'nullable|string|max:20|unique:cliente,ruc_ci,' . $cliente->id,
            'celular' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100|unique:cliente,email,' . $cliente->id,
            'direccion' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'activo' => 'boolean',
        ];
    }
}
