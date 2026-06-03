<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteCreditoMovimiento extends Model
{
    use HasFactory;

    protected $table = 'cliente_credito_movimiento';

    protected $fillable = [
        'cliente_id', 'venta_id', 'pago_id', 'tipo', 'monto',
        'saldo_anterior', 'saldo_posterior', 'fecha_vencimiento',
        'descripcion'
    ];

    protected $casts = [
        'monto' => 'integer',
        'saldo_anterior' => 'integer',
        'saldo_posterior' => 'integer',
        'fecha_vencimiento' => 'date',
    ];

    public $timestamps = false; // solo tiene created_at

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    public function pago()
    {
        return $this->belongsTo(ClientePago::class, 'pago_id');
    }
}
