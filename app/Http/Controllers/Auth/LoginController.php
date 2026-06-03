<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = $this->authService->login($credentials);

        if (!$usuario) {
            return back()->withErrors([
                'email' => 'Credenciales inválidas o usuario inactivo.',
            ]);
        }

        return redirect()->intended('/dashboard');
    }
}
