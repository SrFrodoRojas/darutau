<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaMovimiento extends Model
{
    protected $table = 'categoria_movimiento';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'tipo',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function cajaMovimientos()
    {
        return $this->hasMany(CajaMovimiento::class, 'categoria_movimiento_id');
    }
}
