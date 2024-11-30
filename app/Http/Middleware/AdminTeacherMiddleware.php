<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminTeacherMiddleware {
    public function handle(Request $request, Closure $next): Response {
        if ($request->user() && ($request->user()->role === 'admin' || $request->user()->role === 'teacher')) {
            return $next($request);
        }

        return redirect('/');
    }
}
