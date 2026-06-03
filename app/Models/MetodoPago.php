<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodo_pago';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'codigo',
        'activo',
        'requiere_referencia',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'requiere_referencia' => 'boolean',
    ];
}
