<?php

namespace App\Policies;

use App\Models\Marca;
use App\Models\Usuario;

class MarcaPolicy
{
    public function before(Usuario $user, $ability)
    {
        if ($user->rol && $user->rol->nombre === 'ADMIN') return true;
    }

    public function viewAny(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE', 'VENTAS', 'DEPOSITO']);
    }

    public function view(Usuario $user, Marca $marca)
    {
        return $this->viewAny($user);
    }

    public function create(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function update(Usuario $user, Marca $marca)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function delete(Usuario $user, Marca $marca)
    {
        return $user->rol->nombre === 'ADMIN';
    }

    public function restore(Usuario $user, Marca $marca)
    {
        return $user->rol->nombre === 'ADMIN';
    }

    public function forceDelete(Usuario $user, Marca $marca)
    {
        return false;
    }
}
