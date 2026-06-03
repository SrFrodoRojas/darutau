<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositoProducto extends Model
{
    protected $table = 'deposito_producto';
    public $timestamps = true;
    protected $fillable = [
        'deposito_id', 'producto_id', 'stock', 'stock_reservado', 'stock_minimo', 'stock_maximo'
    ];

    public function deposito()
    {
        return $this->belongsTo(Deposito::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
