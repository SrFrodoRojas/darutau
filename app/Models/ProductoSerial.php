<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class ProductoSerial extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'producto_serial';
    protected $fillable = [
        'producto_id', 'serial', 'estado', 'fecha_ingreso', 'fecha_salida',
        'fecha_vencimiento_garantia', 'proveedor_id', 'notas'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function movimientos()
    {
        return $this->hasMany(ProductoSerialMovimiento::class, 'serial_id');
    }
}
