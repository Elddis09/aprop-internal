<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckPasswordChanged
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Konversi string ke Carbon
            $passwordChangedAt = $user->password_changed_at ? Carbon::parse($user->password_changed_at) : null;
            $lastCheckedAt = session('password_checked_at');

            if ($passwordChangedAt && (!$lastCheckedAt || $passwordChangedAt->gt($lastCheckedAt))) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Password Anda telah diubah. Silakan login kembali.');
            }

            session(['password_checked_at' => now()]);
        }

        return $next($request);
    }
}
