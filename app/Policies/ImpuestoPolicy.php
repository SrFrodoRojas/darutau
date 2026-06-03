<?php

namespace App\Policies;

use App\Models\Impuesto;
use App\Models\Usuario;

class ImpuestoPolicy
{
    public function before(Usuario $user, $ability)
    {
        if ($user->rol && $user->rol->nombre === 'ADMIN') return true;
    }

    public function viewAny(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE', 'VENTAS', 'DEPOSITO']);
    }

    public function view(Usuario $user, Impuesto $impuesto)
    {
        return $this->viewAny($user);
    }

    public function create(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function update(Usuario $user, Impuesto $impuesto)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE']);
    }

    public function delete(Usuario $user, Impuesto $impuesto)
    {
        // No se elimina físicamente, solo se desactiva. Permitir solo a ADMIN.
        return $user->rol->nombre === 'ADMIN';
    }
}
