<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\ProductoSerial;

class ProductoSerialPolicy
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

    public function view(Usuario $user, ProductoSerial $serial)
    {
        return $this->viewAny($user);
    }

    public function create(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function update(Usuario $user, ProductoSerial $serial)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function delete(Usuario $user, ProductoSerial $serial)
    {
        return $user->rol->nombre === 'ADMIN';
    }
}
