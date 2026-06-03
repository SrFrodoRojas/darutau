<?php

namespace App\Http\Requests\ClientePago;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientePagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('makePayment', \App\Models\ClientePago::class);
    }

    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:cliente,id',
            'monto' => 'required|integer|min:1',
            'metodo_pago_id' => 'nullable|exists:metodo_pago,id',
            'referencia' => 'nullable|string|max:100',
            'caja_id' => 'required|exists:caja,id|in:' . $this->obtenerCajaAbierta(),
        ];
    }

    protected function obtenerCajaAbierta()
    {
        $cajaAbierta = auth()->user()->cajas()->where('estado', 'abierta')->first();
        return $cajaAbierta ? $cajaAbierta->id : 0;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->metodo_pago_id && $this->metodo_pago_id == 3 && empty($this->referencia)) {
                $validator->errors()->add('referencia', 'La transferencia requiere una referencia.');
            }
        });
    }
}
