<?php

namespace App\Http\Requests\Admin\Stock;

use Illuminate\Foundation\Http\FormRequest;

class AjusteStockRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'producto_id' => 'required|exists:producto,id',
            'deposito_id' => 'required|exists:deposito,id',
            'cantidad' => 'required|integer|not_in:0',
            'motivo' => 'required|string|max:255',
        ];
    }
}
