<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AutoLoginDemo
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            $demo = User::where('email', 'demo@ayoda.com')->first();
            if ($demo) {
                Auth::login($demo, true);
            }
        }

        return $next($request);
    }
}
