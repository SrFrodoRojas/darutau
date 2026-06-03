<?php

namespace App\Policies;

use App\Models\CategoriaMovimiento;
use App\Models\Usuario;

class CategoriaMovimientoPolicy
{
    public function before(Usuario $user, $ability)
    {
        if ($user->rol && $user->rol->nombre === 'ADMIN') return true;
    }

    public function viewAny(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE', 'CAJA']);
    }

    public function view(Usuario $user, CategoriaMovimiento $categoriaMovimiento)
    {
        return $this->viewAny($user);
    }

    public function create(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function update(Usuario $user, CategoriaMovimiento $categoriaMovimiento)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function delete(Usuario $user, CategoriaMovimiento $categoriaMovimiento)
    {
        return $user->rol->nombre === 'ADMIN';
    }
}
