<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DemoVerified
{
    public function handle(Request $request, Closure $next)
    {
        // Demo mode: lewati cek verifikasi email
        return $next($request);
    }
}
