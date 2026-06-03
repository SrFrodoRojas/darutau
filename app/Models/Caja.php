<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caja extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'caja';

    protected $fillable = [
        'usuario_id', 'empresa_id', 'fecha_apertura', 'fecha_cierre',
        'monto_inicial', 'monto_final', 'saldo_real', 'saldo_actual',
        'estado', 'observaciones_apertura', 'observaciones_cierre', 'moneda'
    ];

    protected $casts = [
        'fecha_apertura' => 'datetime',
        'fecha_cierre' => 'datetime',
        'monto_inicial' => 'integer',
        'monto_final' => 'integer',
        'saldo_real' => 'integer',
        'saldo_actual' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function movimientos()
    {
        return $this->hasMany(CajaMovimiento::class, 'caja_id');
    }
}
