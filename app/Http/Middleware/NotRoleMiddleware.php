<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class NotRoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check() && strtolower(Auth::user()->role) !== strtolower($role)) {
            return $next($request);
        }

        abort(403, 'Akses ditolak.');
    }
}
