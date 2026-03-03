<?php

namespace App\Http\Middleware;

use App\Models\UserLogin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            UserLogin::where('user_id', Auth::id())
                ->whereNull('logout_at')
                ->latest()
                ->update([
                    'last_activity' => now()
                ]);
        }
        return $next($request);
    }
}
