<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Fields that should NEVER be sanitized (passwords, tokens, etc.)
     */
    private array $skipFields = [
        'password',
        'password_confirmation',
        'current_password',
        '_token',
        '_method',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        $cleaned = $this->sanitizeArray($input);
        $request->merge($cleaned);

        return $next($request);
    }

    private function sanitizeArray(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (in_array($key, $this->skipFields, true)) {
                $result[$key] = $value;
                continue;
            }
            if (is_array($value)) {
                $result[$key] = $this->sanitizeArray($value);
            } elseif (is_string($value)) {
                $result[$key] = $this->sanitizeString($value);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    private function sanitizeString(string $value): string
    {
        // Remove null bytes
        $value = str_replace("\0", '', $value);

        // Strip HTML tags from non-content fields (basic XSS prevention)
        // strip_tags allows no HTML — htmlspecialchars handles output encoding in Blade
        $value = strip_tags($value);

        // Remove control characters except newlines and tabs
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $value);

        // Trim whitespace
        $value = trim($value);

        return $value;
    }
}