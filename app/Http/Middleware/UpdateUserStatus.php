<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip update for AJAX/Polling or Logout to prevent race conditions during logout
        if (Auth::check() && !$request->ajax() && !$request->is('logout', 'chat/fetch*')) {
            $user = Auth::user();
            $user->update([
                'last_seen_at' => now(),
                'is_online' => true,
            ]);
        }

        return $next($request);
    }
}
