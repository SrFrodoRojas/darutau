<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoSerialMovimiento extends Model
{
    protected $table = 'producto_serial_movimiento';
    public $timestamps = true;
    protected $fillable = [
        'serial_id', 'tipo_movimiento', 'referencia_tipo', 'referencia_id',
        'estado_anterior', 'estado_nuevo', 'fecha_movimiento', 'usuario_id', 'notas'
    ];

    public function serial()
    {
        return $this->belongsTo(ProductoSerial::class, 'serial_id');
    }
}
