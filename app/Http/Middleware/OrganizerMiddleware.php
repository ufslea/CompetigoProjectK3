<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OrganizerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login dulu.');
        }

        if (Auth::user()->role !== 'organizer') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
