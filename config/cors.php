<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    // Mengizinkan CORS untuk semua rute API dan sanctum cookie
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'storage/*'],

    // Metode HTTP yang diizinkan (GET, POST, PUT, DELETE, dll)
    'allowed_methods' => ['*'],

    // URL Frontend yang diizinkan mengakses API ini
    // Sangat penting: Jangan pakai '*' jika ingin pakai cookie/credentials
    'allowed_origins' => [
        'http://localhost:5173', // Default Vite
        'http://127.0.0.1:5173', // Alternatif Vite
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Wajib true jika nanti pakai Sanctum SPA authentication (cookie-based)
    'supports_credentials' => true,

];