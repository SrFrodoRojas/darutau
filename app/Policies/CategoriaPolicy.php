<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\Usuario;

class CategoriaPolicy
{
    public function before(Usuario $user, $ability)
    {
        if ($user->rol && $user->rol->nombre === 'ADMIN') return true;
    }

    public function viewAny(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE', 'VENTAS', 'DEPOSITO']);
    }

    public function view(Usuario $user, Categoria $categoria)
    {
        return $this->viewAny($user);
    }

    public function create(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function update(Usuario $user, Categoria $categoria)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function delete(Usuario $user, Categoria $categoria)
    {
        return $user->rol->nombre === 'ADMIN';
    }

    public function restore(Usuario $user, Categoria $categoria)
    {
        return $user->rol->nombre === 'ADMIN';
    }

    public function forceDelete(Usuario $user, Categoria $categoria)
    {
        return false;
    }
}
