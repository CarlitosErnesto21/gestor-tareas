<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

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
        Vite::prefetch(concurrency: 3);

        // Forzar HTTPS en producción
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }

        // Configurar longitud predeterminada de cadenas para MySQL
        Schema::defaultStringLength(191);

        // Habilitar foreign key constraints
        if (config('database.default') === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
