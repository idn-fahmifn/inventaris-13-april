<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Restriced access for admin and petugas

        if(!Auth::user()->check || !Auth::user()->is_admin) {
            // jika bukan admin, arahkan ke dashboard petugas
            return redirect()->route('dashboard.petugas');
        }

        return $next($request);
    }
}
