<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait para modelos que tienen movimientos de crédito (Cliente, Proveedor).
 */
trait HasMovimientos
{
    /**
     * Relación polimórfica con los movimientos de crédito.
     * Debe ser sobrescrita en el modelo con la relación concreta.
     */
    public function movimientosCredito(): MorphMany
    {
        // En la práctica se define la relación específica: hasMany(ClienteCreditoMovimiento::class, 'cliente_id')
        return $this->morphMany(\App\Models\ClienteCreditoMovimiento::class, 'movementable');
    }

    /**
     * Obtener el último movimiento.
     */
    public function ultimoMovimientoCredito()
    {
        return $this->movimientosCredito()->latest('created_at')->first();
    }
}
