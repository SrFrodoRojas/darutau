<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteCredito extends Model
{
    use HasFactory, Auditable;

    protected $table = 'cliente_credito';

    protected $fillable = [
        'cliente_id', 'saldo_actual', 'limite_credito', 'dias_credito'
    ];

    protected $casts = [
        'saldo_actual' => 'integer',
        'limite_credito' => 'integer',
        'dias_credito' => 'integer',
    ];

    public $timestamps = true; // tiene created_at, updated_at

    /**
     * Relación con cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
