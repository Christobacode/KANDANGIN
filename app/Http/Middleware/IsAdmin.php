<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    // Cek apakah user login dan rolenya admin
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }
    // Jika bukan admin, lempar balik ke home
    return redirect('/')->with('error', 'Akses ditolak! Halaman ini khusus Admin.');
}
}
