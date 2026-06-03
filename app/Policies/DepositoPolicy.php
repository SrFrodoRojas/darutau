<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Deposito;

class DepositoPolicy
{
    public function before($user, $ability)
    {
        if ($user->rol && $user->rol->nombre === 'ADMIN') {
            return true;
        }
    }

    public function viewAny(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE', 'DEPOSITO', 'VENTAS']);
    }

    public function view(Usuario $user, Deposito $deposito)
    {
        return $this->viewAny($user);
    }

    public function create(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function update(Usuario $user, Deposito $deposito)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function delete(Usuario $user, Deposito $deposito)
    {
        return $user->rol->nombre === 'ADMIN';
    }
}
