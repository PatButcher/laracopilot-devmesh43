<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSlug
{
    /**
     * Validate route parameters that are slugs to prevent injection.
     * Slugs must be: lowercase alphanumeric, hyphens only, max 200 chars.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeParams = $request->route()?->parameters() ?? [];

        foreach ($routeParams as $key => $value) {
            // Only validate string params named 'slug'
            if ($key === 'slug' && is_string($value)) {
                if (!preg_match('/^[a-z0-9\-]{1,200}$/', $value)) {
                    abort(404);
                }
            }

            // Validate numeric IDs
            if (in_array($key, ['id', 'trackId', 'userId'], true)) {
                if (!ctype_digit((string) $value) || (int) $value <= 0) {
                    abort(404);
                }
            }
        }

        return $next($request);
    }
}