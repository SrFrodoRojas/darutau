<?php

namespace App\Http\Requests\Admin\Marca;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarcaRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', \App\Models\Marca::class);
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:100|unique:marca,nombre',
            'descripcion' => 'nullable|string',
            'logo' => 'nullable|string|max:255',
            'sitio_web' => 'nullable|url|max:255',
            'activo' => 'sometimes|boolean',
        ];
    }
}
