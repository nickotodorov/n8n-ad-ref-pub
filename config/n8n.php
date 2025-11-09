<?php

declare(strict_types=1);

return [
    'api' => [
        'base_url' => env('N8N_API_BASE_URL', 'http://n8n:5678'),
        'key' => env('N8N_API_KEY'),
    ],
    'timeout' => (int) env('N8N_TIMEOUT', 120),
];
