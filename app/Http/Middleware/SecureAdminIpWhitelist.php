<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecureAdminIpWhitelist
{
    public function handle(Request $request, Closure $next): Response
    {
        // Get whitelist from environment (comma-separated IPs/CIDRs)
        $whitelistRaw = env('ADMIN_IP_WHITELIST', '');

        // If no whitelist configured, allow all (backward compatible)
        if (empty(trim($whitelistRaw))) {
            return $next($request);
        }

        $whitelist = array_map('trim', explode(',', $whitelistRaw));
        $clientIp  = $request->ip();

        foreach ($whitelist as $allowedIp) {
            if ($this->ipMatches($clientIp, $allowedIp)) {
                return $next($request);
            }
        }

        Log::critical('Admin access attempt from non-whitelisted IP', [
            'ip'  => $clientIp,
            'url' => $request->fullUrl(),
            'ua'  => $request->userAgent(),
        ]);

        abort(403, 'Access Denied');
    }

    private function ipMatches(string $ip, string $cidrOrIp): bool
    {
        // Exact match
        if ($ip === $cidrOrIp) {
            return true;
        }

        // CIDR range match
        if (str_contains($cidrOrIp, '/')) {
            [$subnet, $bits] = explode('/', $cidrOrIp);
            $bits    = (int) $bits;
            $ipLong  = ip2long($ip);
            $subLong = ip2long($subnet);
            if ($ipLong === false || $subLong === false) {
                return false;
            }
            $mask = $bits > 0 ? (~0 << (32 - $bits)) : 0;
            return ($ipLong & $mask) === ($subLong & $mask);
        }

        return false;
    }
}