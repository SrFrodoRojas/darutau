<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\Usuario;

class ClientePolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE', 'VENTAS', 'CAJA', 'DEPOSITO']);
    }

    public function view(Usuario $usuario, Cliente $cliente): bool
    {
        return $this->viewAny($usuario);
    }

    public function create(Usuario $usuario): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE', 'VENTAS']);
    }

    public function update(Usuario $usuario, Cliente $cliente): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE', 'VENTAS']);
    }

    public function delete(Usuario $usuario, Cliente $cliente): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE']);
    }

    public function restore(Usuario $usuario, Cliente $cliente): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE']);
    }

    public function forceDelete(Usuario $usuario, Cliente $cliente): bool
    {
        return $usuario->rol->codigo === 'ADMIN';
    }

    public function viewMovements(Usuario $usuario, Cliente $cliente): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE', 'VENTAS', 'CAJA']);
    }
}
