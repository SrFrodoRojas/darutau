<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpresaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $empresaId = Auth::user()->empresa_id;
            if (!$empresaId) {
                Auth::logout();
                return redirect('/login')->withErrors(['error' => 'Usuario sin empresa asignada.']);
            }
            session(['empresa_id' => $empresaId]);
        }

        return $next($request);
    }
}
