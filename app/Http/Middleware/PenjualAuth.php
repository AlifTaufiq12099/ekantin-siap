<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if penjual is logged in via session
        if (!session()->has('penjual_id')) {
            return redirect('/login/penjual');
        }

        return $next($request);
    }
}
