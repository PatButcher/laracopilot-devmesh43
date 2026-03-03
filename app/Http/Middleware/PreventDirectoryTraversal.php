<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PreventDirectoryTraversal
{
    /**
     * Patterns that indicate path traversal or injection attempts.
     */
    private array $suspiciousPatterns = [
        '../',
        '..\\',
        '%2e%2e%2f',
        '%2e%2e/',
        '..%2f',
        '%2e%2e%5c',
        '<script',
        'javascript:',
        'vbscript:',
        'onload=',
        'onerror=',
        'eval(',
        'base64_decode',
        'exec(',
        'system(',
        'passthru(',
        'shell_exec',
        'phpinfo()',
        '/etc/passwd',
        '/etc/shadow',
        'UNION SELECT',
        'union select',
        '1=1--',
        "' OR '",
        '" OR "',
        'DROP TABLE',
        'drop table',
        'INSERT INTO',
        'SELECT *',
        'xp_cmdshell',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $url = urldecode($request->fullUrl());
        $allInput = json_encode($request->all());

        foreach ($this->suspiciousPatterns as $pattern) {
            if (
                stripos($url, $pattern) !== false ||
                stripos($allInput, $pattern) !== false
            ) {
                Log::critical('Suspicious request blocked', [
                    'ip'      => $request->ip(),
                    'pattern' => $pattern,
                    'url'     => $request->fullUrl(),
                    'ua'      => $request->userAgent(),
                    'method'  => $request->method(),
                ]);

                abort(400, 'Bad Request');
            }
        }

        return $next($request);
    }
}