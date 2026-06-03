<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostoHistorial extends Model
{
    protected $table = 'costo_historial';
    public $timestamps = false;
    protected $fillable = [
        'producto_id', 'fecha_cambio', 'costo_anterior', 'costo_nuevo',
        'compra_detalle_id', 'usuario_id', 'motivo'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function compraDetalle()
    {
        return $this->belongsTo(CompraDetalle::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
