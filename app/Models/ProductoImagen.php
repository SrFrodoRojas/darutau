<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class ProductoImagen extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'producto_imagen';
    protected $fillable = ['producto_id', 'ruta', 'alt_text', 'orden', 'principal'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
