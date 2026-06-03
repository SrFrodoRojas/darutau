<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoVenta extends Model
{
    protected $table = 'estado_venta';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'orden',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'estado_venta_id');
    }
}
