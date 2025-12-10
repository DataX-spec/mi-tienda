<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\URL; // 👈 Importamos URL

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 👇 Ajuste para evitar error de longitud en índices MySQL
        Schema::defaultStringLength(191);

        // 👇 Forzar HTTPS en producción (Render usa HTTPS)
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
