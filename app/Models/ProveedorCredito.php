<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorCredito extends Model
{
    use HasFactory, Auditable;

    protected $table = 'proveedor_credito';

    protected $fillable = [
        'proveedor_id', 'saldo_actual', 'limite_credito', 'dias_credito'
    ];

    public $timestamps = true;

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
