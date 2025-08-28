<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyIsMurid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika pengguna sudah login DAN perannya adalah 'murid'
        if (auth()->check() && auth()->user()->role === 'murid') {
            // Jika ya, izinkan akses
            return $next($request);
        }

        // Jika tidak, tolak akses dengan pesan 'Forbidden'
        abort(403, 'AKSES DITOLAK: HANYA UNTUK MURID.');
    }
}
