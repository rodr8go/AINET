<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Garante que o utilizador está autenticado e tem o tipo correto
        if (!Auth::check() || Auth::user()->user_type !== $role) {
            abort(403, 'Acesso não autorizado. Não tens permissões para aceder a esta página.');
        }

        return $next($request);
    }
}