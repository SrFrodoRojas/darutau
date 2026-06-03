<?php

namespace App\Http\Requests\Proveedor;

use Illuminate\Foundation\Http\FormRequest;

class StoreProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('create', \App\Models\Proveedor::class);
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'ruc' => 'nullable|string|max:20|unique:proveedor,ruc',
            'telefono' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100|unique:proveedor,email',
            'direccion' => 'nullable|string',
            'empresa' => 'nullable|string|max:100',
            'activo' => 'boolean',
        ];
    }
}
