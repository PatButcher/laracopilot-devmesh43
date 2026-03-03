<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        'rate.limit' => \App\Http\Middleware\RateLimitRequests::class,
        'brute.force' => \App\Http\Middleware\PreventBruteForce::class,
        'honeypot' => \App\Http\Middleware\Honeypot::class,
        'admin.ip' => \App\Http\Middleware\SecureAdminIpWhitelist::class,
        'admin.auth' => \App\Http\Middleware\AdminAuthCheck::class,
        'file.upload' => \App\Http\Middleware\ValidateFileUpload::class,
        'validate.slug' => \App\Http\Middleware\ValidateSlug::class,
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
