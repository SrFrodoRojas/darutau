<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovimiento extends Model
{
    protected $table = 'stock_movimiento';
    public $timestamps = false;
    protected $fillable = [
        'producto_id', 'deposito_id', 'tipo', 'referencia_tipo', 'referencia_id',
        'cantidad', 'stock_prev', 'stock_post', 'usuario_id', 'notas'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function deposito()
    {
        return $this->belongsTo(Deposito::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
