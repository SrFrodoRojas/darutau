<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Trait para modelos que tienen una relación de crédito (Cliente, Proveedor).
 */
trait HasCreditos
{
    /**
     * Obtener la relación polimórfica o específica del crédito.
     * En la práctica, es una relación hasOne con la tabla de crédito correspondiente.
     * Este método debe ser sobrescrito en el modelo que use el trait.
     */
    public function credito(): MorphOne
    {
        // Llamada genérica; se debe implementar en el modelo con la relación concreta
        return $this->morphOne(\App\Models\ClienteCredito::class, 'creditable');
    }

    /**
     * Obtener el saldo actual del crédito.
     */
    public function getSaldoCreditoAttribute(): int
    {
        return $this->credito ? (int) $this->credito->saldo_actual : 0;
    }

    /**
     * Obtener el límite de crédito.
     */
    public function getLimiteCreditoAttribute(): int
    {
        return $this->credito ? (int) $this->credito->limite_credito : 0;
    }

    /**
     * Obtener los días de crédito.
     */
    public function getDiasCreditoAttribute(): int
    {
        return $this->credito ? (int) $this->credito->dias_credito : 0;
    }

    /**
     * Calcular el saldo disponible (límite - saldo actual).
     */
    public function getSaldoDisponibleAttribute(): int
    {
        return max(0, $this->limite_credito - $this->saldo_credito);
    }
}
