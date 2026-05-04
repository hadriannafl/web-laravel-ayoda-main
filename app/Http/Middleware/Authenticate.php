<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            if (! $this->auth->check()) {
                $demo = User::where('email', 'demo@ayoda.com')->first();
                if ($demo) {
                    $this->auth->login($demo, true);
                }
            }
        } catch (\Throwable $e) {
            // DB tidak tersedia — lanjut tanpa auth (demo mode)
        }

        // Demo mode: selalu lanjut, tidak pernah redirect ke login
        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
