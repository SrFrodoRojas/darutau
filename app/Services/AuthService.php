<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(array $credentials): ?Usuario
    {
        $usuario = Usuario::where('email', $credentials['email'])
            ->where('activo', 1)
            ->whereNotNull('empresa_id')
            ->whereNotNull('rol_id')
            ->first();

        if (!$usuario || !Hash::check($credentials['password'], $usuario->password)) {
            return null;
        }

        Auth::login($usuario);

        // Guardar datos en sesión
        session([
            'empresa_id' => $usuario->empresa_id,
            'rol_id' => $usuario->rol_id,
            'user_id' => $usuario->id
        ]);

        return $usuario;
    }

    public function logout(): void
    {
        Auth::logout();
        session()->flush();
    }
}
