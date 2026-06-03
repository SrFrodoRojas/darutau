<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasCreditos;
use App\Traits\HasMovimientos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory, SoftDeletes, Auditable, HasCreditos, HasMovimientos;

    protected $table = 'proveedor';

    protected $fillable = [
        'nombre', 'ruc', 'telefono', 'celular', 'email',
        'direccion', 'empresa', 'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function credito()
    {
        return $this->hasOne(ProveedorCredito::class, 'proveedor_id');
    }

    public function movimientosCredito()
    {
        return $this->hasMany(ProveedorCreditoMovimiento::class, 'proveedor_id');
    }

    public function pagos()
    {
        return $this->hasMany(ProveedorPago::class, 'proveedor_id');
    }

    protected static function booted()
    {
        static::created(function ($proveedor) {
            $proveedor->credito()->create([
                'saldo_actual' => 0,
                'limite_credito' => 0,
                'dias_credito' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
