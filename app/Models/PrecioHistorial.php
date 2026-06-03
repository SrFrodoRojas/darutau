<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrecioHistorial extends Model
{
    protected $table = 'precio_historial';
    public $timestamps = false;
    protected $fillable = ['producto_id', 'precio_anterior', 'precio_nuevo', 'usuario_id'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
