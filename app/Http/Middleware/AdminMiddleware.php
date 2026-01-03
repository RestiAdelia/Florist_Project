<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user(); // ✅ PALING AMAN

        if ($user->email !== 'admin@gmail.com') {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
