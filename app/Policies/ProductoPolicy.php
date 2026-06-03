<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Producto;

class ProductoPolicy
{
    public function before($user, $ability)
    {
        if ($user->rol && $user->rol->nombre === 'ADMIN') {
            return true;
        }
    }

    public function viewAny(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE', 'VENTAS', 'DEPOSITO']);
    }

    public function view(Usuario $user, Producto $producto)
    {
        return $this->viewAny($user);
    }

    public function create(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function update(Usuario $user, Producto $producto)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function delete(Usuario $user, Producto $producto)
    {
        return $user->rol->nombre === 'ADMIN';
    }

    public function ajustarStock(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'DEPOSITO']);
    }
}
