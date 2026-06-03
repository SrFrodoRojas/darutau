<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorCreditoMovimiento extends Model
{
    use HasFactory;

    protected $table = 'proveedor_credito_movimiento';

    protected $fillable = [
        'proveedor_id', 'compra_id', 'pago_id', 'tipo', 'monto',
        'saldo_anterior', 'saldo_posterior', 'fecha_vencimiento',
        'descripcion'
    ];

    public $timestamps = false;

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    public function pago()
    {
        return $this->belongsTo(ProveedorPago::class, 'pago_id');
    }
}
