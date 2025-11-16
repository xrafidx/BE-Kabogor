<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->is_admin) {
            
            // 2. Jika ya, lanjutkan request ke Controller
            return $next($request);
        }
        return response()->json([
            'message' => 'Akses ditolak. Hanya admin yang diizinkan.'
        ], 403);
    }
}
