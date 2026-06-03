<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorPago extends Model
{
    use HasFactory, Auditable;

    protected $table = 'proveedor_pago';

    protected $fillable = [
        'proveedor_id', 'monto', 'metodo_pago_id', 'referencia',
        'caja_id', 'created_by'
    ];

    public $timestamps = false;

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }
}
