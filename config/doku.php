<?php

return [
    'base_url' => env('DOKU_BASE_URL', 'https://api-sandbox.doku.com'),

    'webhook' => env('DOKU_WEBHOOK_URL'),

    'client_id'     => env('DOKU_CLIENT_ID'),

    'client_secret' => env('DOKU_CLIENT_SECRET'),

    'merchant_id' => env('DOKU_MERCHANT_ID'),

    'terminal_id' => env('DOKU_TERMINAL_ID'),
    
    'bank_settlement_id' => env('DOKU_PLATFORM_SETTLEMENT_ID'),
];