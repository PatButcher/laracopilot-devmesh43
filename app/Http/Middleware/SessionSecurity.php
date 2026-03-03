<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SessionSecurity
{
    public function handle(Request $request, Closure $next): Response
    {
        // Detect session hijacking via User-Agent fingerprint
        if (Auth::check()) {
            $currentUA = md5($request->userAgent() . $request->ip());
            $storedUA  = session('_security_fingerprint');

            if ($storedUA === null) {
                // First request — store fingerprint
                session(['_security_fingerprint' => $currentUA]);
            } elseif ($storedUA !== $currentUA) {
                // Fingerprint changed — possible session hijack
                Log::warning('Session fingerprint mismatch — possible hijack', [
                    'ip'   => $request->ip(),
                    'ua'   => $request->userAgent(),
                    'user' => Auth::id(),
                ]);

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['email' => 'Your session has expired for security reasons. Please log in again.']);
            }
        }

        // Idle timeout — log out after 2 hours of inactivity
        if (Auth::check()) {
            $lastActivity = session('_last_activity', now()->timestamp);
            if (now()->timestamp - $lastActivity > 7200) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['email' => 'You have been logged out due to inactivity.']);
            }
            session(['_last_activity' => now()->timestamp]);
        }

        return $next($request);
    }
}