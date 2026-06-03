<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    protected $table = 'empresa';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'activo',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'empresa_id');
    }
}
