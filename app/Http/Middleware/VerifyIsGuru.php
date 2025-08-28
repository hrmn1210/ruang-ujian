<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyIsGuru
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'guru') {
            return $next($request);
        }

        // Ganti baris ini
        // return redirect('/');

        // Menjadi baris ini
        abort(403);
    }
}
