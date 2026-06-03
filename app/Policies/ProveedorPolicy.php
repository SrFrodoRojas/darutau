<?php

namespace App\Policies;

use App\Models\Proveedor;
use App\Models\Usuario;

class ProveedorPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE', 'VENTAS', 'CAJA', 'DEPOSITO']);
    }

    public function view(Usuario $usuario, Proveedor $proveedor): bool
    {
        return $this->viewAny($usuario);
    }

    public function create(Usuario $usuario): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE']);
    }

    public function update(Usuario $usuario, Proveedor $proveedor): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE']);
    }

    public function delete(Usuario $usuario, Proveedor $proveedor): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE']);
    }

    public function restore(Usuario $usuario, Proveedor $proveedor): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE']);
    }

    public function forceDelete(Usuario $usuario, Proveedor $proveedor): bool
    {
        return $usuario->rol->codigo === 'ADMIN';
    }

    public function viewMovements(Usuario $usuario, Proveedor $proveedor): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE', 'CAJA']);
    }
}
