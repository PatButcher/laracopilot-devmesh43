<?php

use Illuminate\Support\Str;

return [

    'driver' => env('SESSION_DRIVER', 'file'),

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    // Force HTTPS-only cookie transmission
    'encrypt' => env('SESSION_ENCRYPT', true),

    'files' => storage_path('framework/sessions'),

    'connection' => env('SESSION_CONNECTION'),

    'table' => env('SESSION_TABLE', 'sessions'),

    'store' => env('SESSION_STORE'),

    'lottery' => [2, 100],

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_') . '_session'
    ),

    'path' => env('SESSION_PATH', '/'),

    'domain' => env('SESSION_DOMAIN'),

    // Never send session cookie over HTTP
    'secure' => env('SESSION_SECURE_COOKIE', false),

    // Prevent JavaScript from accessing session cookie
    'http_only' => true,

    // Strict SameSite policy — prevents CSRF via cross-site requests
    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    // Partition cookie for privacy
    'partitioned' => false,

];