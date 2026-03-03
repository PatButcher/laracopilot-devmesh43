<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Honeypot
{
    /**
     * Honeypot field name — bots fill this, humans leave it empty.
     * This field is hidden via CSS in forms.
     */
    private string $honeypotField = 'website_url';

    /**
     * Minimum time (seconds) a human needs to fill a form.
     * Bots submit instantly.
     */
    private int $minSubmitSeconds = 2;

    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->isMethod('POST')) {
            return $next($request);
        }

        // Check honeypot field — should always be empty
        if ($request->filled($this->honeypotField)) {
            Log::warning('Honeypot triggered — bot detected', [
                'ip'    => $request->ip(),
                'url'   => $request->fullUrl(),
                'field' => $request->input($this->honeypotField),
            ]);

            // Silently succeed to confuse bots (don't reveal detection)
            return redirect()->back()->with('success', 'Thank you!');
        }

        // Time-based check
        $formLoadedAt = (int) $request->input('_form_loaded_at', 0);
        if ($formLoadedAt > 0) {
            $elapsed = now()->timestamp - $formLoadedAt;
            if ($elapsed < $this->minSubmitSeconds) {
                Log::warning('Form submitted too fast — bot suspected', [
                    'ip'      => $request->ip(),
                    'elapsed' => $elapsed,
                    'url'     => $request->fullUrl(),
                ]);
                return redirect()->back()->with('success', 'Thank you!');
            }
        }

        return $next($request);
    }
}