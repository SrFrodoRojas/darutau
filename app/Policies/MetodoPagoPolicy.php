<?php

namespace App\Policies;

use App\Models\MetodoPago;
use App\Models\Usuario;

class MetodoPagoPolicy
{
    public function before(Usuario $user, $ability)
    {
        if ($user->rol && $user->rol->nombre === 'ADMIN') return true;
    }

    public function viewAny(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE', 'VENTAS', 'CAJA']);
    }

    public function view(Usuario $user, MetodoPago $metodoPago)
    {
        return $this->viewAny($user);
    }

    public function create(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function update(Usuario $user, MetodoPago $metodoPago)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function delete(Usuario $user, MetodoPago $metodoPago)
    {
        return $user->rol->nombre === 'ADMIN';
    }
}
