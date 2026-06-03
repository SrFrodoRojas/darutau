<?php

namespace App\Http\Requests\Admin\Categoria;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', \App\Models\Categoria::class);
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:100|unique:categoria,nombre',
            'descripcion' => 'nullable|string',
            'activo' => 'sometimes|boolean',
        ];
    }
}
