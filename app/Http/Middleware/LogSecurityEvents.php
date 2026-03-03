<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogSecurityEvents
{
    /**
     * Routes that should be security-logged.
     */
    private array $monitoredPaths = [
        'login',
        'register',
        'logout',
        'admin',
        'upload',
        'password',
        'profile',
        'playlists',
        'favourites',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $path = $request->path();

        // Log monitored route access
        $isMonitored = false;
        foreach ($this->monitoredPaths as $monitored) {
            if (str_contains($path, $monitored)) {
                $isMonitored = true;
                break;
            }
        }

        // Log authentication events
        if ($request->isMethod('POST') && str_contains($path, 'login')) {
            $statusCode = $response->getStatusCode();
            $context = [
                'ip'     => $request->ip(),
                'email'  => $request->input('email', 'n/a'),
                'status' => $statusCode,
                'ua'     => $request->userAgent(),
            ];
            if ($statusCode < 400) {
                Log::info('Login attempt', $context);
            } else {
                Log::warning('Failed login attempt', $context);
            }
        }

        // Log 4xx/5xx responses on monitored paths
        if ($isMonitored && $response->getStatusCode() >= 400) {
            Log::warning('Security-monitored route returned error', [
                'ip'     => $request->ip(),
                'path'   => $path,
                'method' => $request->method(),
                'status' => $response->getStatusCode(),
                'user'   => Auth::id(),
            ]);
        }

        // Log any DELETE requests
        if ($request->isMethod('DELETE')) {
            Log::info('DELETE request', [
                'ip'   => $request->ip(),
                'path' => $path,
                'user' => Auth::id(),
            ]);
        }

        return $response;
    }
}