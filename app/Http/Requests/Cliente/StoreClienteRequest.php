<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('create', \App\Models\Cliente::class);
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'ruc_ci' => 'nullable|string|max:20|unique:cliente,ruc_ci',
            'celular' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100|unique:cliente,email',
            'direccion' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'activo' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ruc_ci.unique' => 'El RUC/CI ya está registrado.',
            'email.unique' => 'El email ya está registrado.',
        ];
    }
}
