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
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if (!auth()->check()) {
    //         return redirect()->route('login');
    //     }

    //     if (!auth()->user()->is_admin) {
    //         abort(403, 'Bạn không có quyền truy cập trang này.');
    //     }

    //     return $next($request);
    // }
}
