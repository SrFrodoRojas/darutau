<?php

namespace App\Policies;

use App\Models\EstadoVenta;
use App\Models\Usuario;

class EstadoVentaPolicy
{
    public function before(Usuario $user, $ability)
    {
        if ($user->rol && $user->rol->nombre === 'ADMIN') return true;
    }

    public function viewAny(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN', 'GERENTE', 'VENTAS']);
    }

    public function view(Usuario $user, EstadoVenta $estadoVenta)
    {
        return $this->viewAny($user);
    }

    public function create(Usuario $user)
    {
        return in_array($user->rol->nombre, ['ADMIN']);
    }

    public function update(Usuario $user, EstadoVenta $estadoVenta)
    {
        return in_array($user->rol->nombre, ['ADMIN']);
    }

    public function delete(Usuario $user, EstadoVenta $estadoVenta)
    {
        // No se permite eliminar estados de venta (solo editar)
        return false;
    }
}
