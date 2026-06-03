<?php

namespace App\Traits;

use App\Models\Empresa;

trait BelongsToEmpresa
{
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function scopeEmpresa($query)
    {
        if (session()->has('empresa_id')) {
            return $query->where('empresa_id', session('empresa_id'));
        }
        return $query;
    }
}
