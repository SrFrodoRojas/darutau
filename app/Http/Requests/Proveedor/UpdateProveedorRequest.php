<?php

namespace App\Http\Requests\Proveedor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        $proveedor = $this->route('proveedor');
        return auth()->user()->can('update', $proveedor);
    }

    public function rules(): array
    {
        $proveedor = $this->route('proveedor');
        return [
            'nombre' => 'required|string|max:100',
            'ruc' => 'nullable|string|max:20|unique:proveedor,ruc,' . $proveedor->id,
            'telefono' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100|unique:proveedor,email,' . $proveedor->id,
            'direccion' => 'nullable|string',
            'empresa' => 'nullable|string|max:100',
            'activo' => 'boolean',
        ];
    }
}
