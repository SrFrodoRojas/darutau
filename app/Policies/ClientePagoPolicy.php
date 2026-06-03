<?php

namespace App\Policies;

use App\Models\ClientePago;
use App\Models\Usuario;

class ClientePagoPolicy
{
    public function makePayment(Usuario $usuario): bool
    {
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE', 'VENTAS', 'CAJA']);
    }

    public function view(Usuario $usuario, ClientePago $pago): bool
    {
        return true; // Todos los autenticados pueden ver pagos?
        // Mejor restringir: solo roles con acceso a cliente
        return in_array($usuario->rol->codigo, ['ADMIN', 'GERENTE', 'VENTAS', 'CAJA']);
    }
}
