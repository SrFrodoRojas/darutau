<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use SoftDeletes;

    protected $table = 'rol';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',   // opcional
        'nivel',         // opcional
        'estado',        // ← cambiar de 'activo' a 'estado'
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    // Si quieres un accessor/mutator para mantener compatibilidad con código que use 'activo'
    // puedes agregar:
    public function getActivoAttribute()
    {
        return $this->estado === 'activo';
    }

    public function setActivoAttribute($value)
    {
        $this->estado = $value ? 'activo' : 'inactivo';
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'rol_id');
    }
}
