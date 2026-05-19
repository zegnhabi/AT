<?php

return [
    'driver' => env('SESSION_DRIVER', 'file'),
    'lifetime' => env('SESSION_LIFETIME', 120),
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => storage_path('framework/sessions'),
    'cookie' => env('SESSION_COOKIE', 'bus_ticketing_session'),
    'path' => '/',
    'secure' => env('SESSION_SECURE_COOKIE'),
    'same_site' => 'lax',
];
