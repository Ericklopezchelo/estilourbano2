<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL; // <-- 1. ¡Añade esta línea!

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
        Schema::defaultStringLength(191);
        
        // --------------------------------------------------------
        // 2. ¡Añade este bloque para forzar HTTPS en producción!
        // --------------------------------------------------------
        if ($this->app->environment('production')) {
             URL::forceScheme('https');
        }
    }
}