<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PreventBruteForce
{
    private int $maxAttempts = 5;
    private int $lockoutMinutes = 15;

    public function handle(Request $request, Closure $next): Response
    {
        $ip  = $request->ip();
        $key = 'brute_force:' . md5($ip . $request->path());
        $lockKey = 'lockout:' . md5($ip . $request->path());

        // Check if IP is locked out
        if (Cache::has($lockKey)) {
            $remainingSeconds = Cache::get($lockKey . '_ttl', $this->lockoutMinutes * 60);

            Log::warning('Brute force lockout hit', [
                'ip'  => $ip,
                'url' => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Too many failed attempts. Account temporarily locked.',
                    'locked_until' => now()->addSeconds($remainingSeconds)->toIso8601String(),
                ], 429);
            }

            return back()->withErrors([
                'email' => 'Too many failed attempts. Please wait ' . $this->lockoutMinutes . ' minutes before trying again.',
            ])->withInput($request->except('password'));
        }

        $response = $next($request);

        // On auth failure (redirect back with errors), increment counter
        if ($response->getStatusCode() === 302 && session()->has('errors')) {
            $attempts = Cache::increment($key);
            if ($attempts === 1) {
                Cache::put($key, 1, $this->lockoutMinutes * 60);
            }
            if ($attempts >= $this->maxAttempts) {
                Cache::put($lockKey, true, $this->lockoutMinutes * 60);
                Cache::put($lockKey . '_ttl', $this->lockoutMinutes * 60, $this->lockoutMinutes * 60);
                Cache::forget($key);
                Log::warning('Brute force lockout triggered', [
                    'ip'       => $ip,
                    'attempts' => $attempts,
                ]);
            }
        }

        // On successful response, clear counter
        if ($response->getStatusCode() < 400) {
            Cache::forget($key);
        }

        return $response;
    }
}