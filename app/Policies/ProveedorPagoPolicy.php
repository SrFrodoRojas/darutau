<?php

namespace App\Policies;

use App\Models\ProveedorPago;
use App\Models\Usuario;

class ProveedorPagoPolicy
{
    public function makePayment(Usuario $usuario): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE', 'CAJA']);
    }

    public function view(Usuario $usuario, ProveedorPago $pago): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE', 'CAJA']);
    }
}
