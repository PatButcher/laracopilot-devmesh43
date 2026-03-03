<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_logged_in')) {
            Log::info('Unauthenticated admin access attempt', [
                'ip'  => $request->ip(),
                'url' => $request->fullUrl(),
                'ua'  => $request->userAgent(),
            ]);

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return redirect()->route('admin.login')->with('info', 'Please log in to access the admin panel.');
        }

        // Session fixation protection: regenerate session ID periodically
        $lastRegen = session('_session_regen_at', 0);
        if (now()->timestamp - $lastRegen > 900) { // every 15 minutes
            $request->session()->regenerate();
            session(['_session_regen_at' => now()->timestamp]);
        }

        return $next($request);
    }
}