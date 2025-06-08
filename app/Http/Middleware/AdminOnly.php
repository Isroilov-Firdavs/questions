<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->id === 1) {
            return $next($request); // Faqat ID=1 bo'lgan userga ruxsat
        }

        abort(403, 'Sizda bu sahifaga kirish huquqi yo‘q.');
    }
}
