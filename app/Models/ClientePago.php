<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientePago extends Model
{
    use HasFactory, Auditable;

    protected $table = 'cliente_pago';

    protected $fillable = [
        'cliente_id', 'monto', 'metodo_pago_id', 'referencia',
        'caja_id', 'created_by'
    ];

    protected $casts = [
        'monto' => 'integer',
    ];

    public $timestamps = false; // solo tiene created_at

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
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
