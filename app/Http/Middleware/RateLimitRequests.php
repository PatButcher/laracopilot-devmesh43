<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RateLimitRequests
{
    /**
     * Max requests per window per IP
     * Key format: [route_type => [max_attempts, decay_seconds]]
     */
    private array $limits = [
        'auth'    => [10, 300],   // 10 attempts per 5 min for login/register
        'upload'  => [20, 3600],  // 20 uploads per hour
        'api'     => [120, 60],   // 120 requests per minute for API-like routes
        'default' => [300, 60],   // 300 requests per minute general
    ];

    public function handle(Request $request, Closure $next, string $type = 'default'): Response
    {
        $ip = $request->ip();
        $key = 'rate_limit:' . $type . ':' . md5($ip);

        [$maxAttempts, $decaySeconds] = $this->limits[$type] ?? $this->limits['default'];

        $attempts = (int) Cache::get($key, 0);

        if ($attempts >= $maxAttempts) {
            Log::warning('Rate limit exceeded', [
                'ip'   => $ip,
                'type' => $type,
                'url'  => $request->fullUrl(),
            ]);

            return response()->json([
                'error'   => 'Too many requests. Please slow down.',
                'retry_after' => $decaySeconds,
            ], 429)->withHeaders([
                'Retry-After'           => $decaySeconds,
                'X-RateLimit-Limit'     => $maxAttempts,
                'X-RateLimit-Remaining' => 0,
            ]);
        }

        // Increment with TTL on first hit
        if ($attempts === 0) {
            Cache::put($key, 1, $decaySeconds);
        } else {
            Cache::increment($key);
        }

        $response = $next($request);

        $response->headers->set('X-RateLimit-Limit', $maxAttempts);
        $response->headers->set('X-RateLimit-Remaining', max(0, $maxAttempts - $attempts - 1));

        return $response;
    }
}