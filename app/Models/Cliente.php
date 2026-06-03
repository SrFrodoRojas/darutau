<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasCreditos;
use App\Traits\HasMovimientos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes, Auditable, HasCreditos, HasMovimientos;

    protected $table = 'cliente';

    protected $fillable = [
        'nombre', 'ruc_ci', 'celular', 'email', 'direccion',
        'fecha_nacimiento', 'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Relación con crédito (cliente_credito)
     */
    public function credito()
    {
        return $this->hasOne(ClienteCredito::class, 'cliente_id');
    }

    /**
     * Relación con movimientos de crédito
     */
    public function movimientosCredito()
    {
        return $this->hasMany(ClienteCreditoMovimiento::class, 'cliente_id');
    }

    /**
     * Relación con pagos
     */
    public function pagos()
    {
        return $this->hasMany(ClientePago::class, 'cliente_id');
    }

    /**
     * Boot: crear automáticamente el registro de crédito después de crear el cliente.
     */
    protected static function booted()
    {
        static::created(function ($cliente) {
            // Crear crédito con valores por defecto
            $cliente->credito()->create([
                'saldo_actual' => 0,
                'limite_credito' => 0,
                'dias_credito' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
