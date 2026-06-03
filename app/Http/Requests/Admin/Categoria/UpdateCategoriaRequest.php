<?php

namespace App\Http\Requests\Admin\Categoria;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoriaRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->categoria);
    }

    public function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:100', Rule::unique('categoria', 'nombre')->ignore($this->categoria)],
            'descripcion' => 'nullable|string',
            'activo' => 'sometimes|boolean',
        ];
    }
}
