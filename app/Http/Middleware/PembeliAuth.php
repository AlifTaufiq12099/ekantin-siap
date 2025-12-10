<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PembeliAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('logged_in') || session('role') !== 'pembeli') {
            return redirect('/login/pembeli');
        }

        return $next($request);
    }
}

