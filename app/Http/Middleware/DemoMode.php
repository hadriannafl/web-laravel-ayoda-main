<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DemoMode
{
    protected array $blockedMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];

    protected array $allowedRoutes = [
        'login',
        'logout',
        'two-factor*',
        'user/confirm-password',
    ];

    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->method(), $this->blockedMethods)) {
            foreach ($this->allowedRoutes as $route) {
                if ($request->is($route)) {
                    return $next($request);
                }
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'demo'    => true,
                    'message' => 'Aksi ini dinonaktifkan di mode demo.',
                ], 403);
            }

            return redirect()->back()->with('demo_warning', 'Aksi ini dinonaktifkan di mode demo. Web ini hanya untuk tampilan desain.');
        }

        return $next($request);
    }
}
