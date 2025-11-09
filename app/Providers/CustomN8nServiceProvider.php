<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\N8NClient;

class CustomN8nServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('n8n', function ($app) {
            return new N8NClient();
        });
    }
}
