<?php

return [
    'env' => env('APP_ENV'),
    'aliases'  => [
        'App' => Illuminate\Support\Facades\App::class,
    ],
    'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),
    'url' => env('APP_URL'),
    'endpoints' => [
        'indodax' => env('INDODAX_URL', null),
        'tokocrypto' => env('TOKOCRYPTO_URL', null)
    ],
    'apiKey' => [
        'indodax' => env('INDODAX_API', null),
    ],
    'secretKey' => [
        'indodax' => env('INDODAX_SECRET', null),
    ],
];
