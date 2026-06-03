<?php

namespace App\Http\Requests\Admin\Marca;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMarcaRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->marca);
    }

    public function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:100', Rule::unique('marca', 'nombre')->ignore($this->marca)],
            'descripcion' => 'nullable|string',
            'logo' => 'nullable|string|max:255',
            'sitio_web' => 'nullable|url|max:255',
            'activo' => 'sometimes|boolean',
        ];
    }
}
