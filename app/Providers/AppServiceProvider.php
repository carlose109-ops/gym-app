<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- IMPORTANTE

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Fuerza HTTPS en toda la aplicación cuando esté en producción
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}