<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CajaMovimiento extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'caja_movimiento';

    protected $fillable = [
        'caja_id', 'usuario_id', 'tipo', 'concepto', 'categoria_movimiento_id',
        'monto', 'moneda', 'metodo_pago_id', 'referencia_tipo', 'referencia_id',
        'comprobante_numero', 'saldo_anterior', 'saldo_posterior', 'descripcion'
    ];

    protected $casts = [
        'monto' => 'integer',
        'saldo_anterior' => 'integer',
        'saldo_posterior' => 'integer',
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function categoriaMovimiento()
    {
        return $this->belongsTo(CategoriaMovimiento::class, 'categoria_movimiento_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }
}
