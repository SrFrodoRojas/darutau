<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;
use App\Traits\BelongsToEmpresa;

class Deposito extends Model
{
    use SoftDeletes, Auditable, BelongsToEmpresa;

    protected $table = 'deposito';
    protected $fillable = [
        'empresa_id', 'nombre', 'ubicacion', 'responsable_id', 'activo'
    ];

    public function responsable()
    {
        return $this->belongsTo(Usuario::class, 'responsable_id');
    }

    public function depositoProductos()
    {
        return $this->hasMany(DepositoProducto::class);
    }

    public function stockMovimientos()
    {
        return $this->hasMany(StockMovimiento::class);
    }
}
