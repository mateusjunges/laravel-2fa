<?php

namespace Junges\TwoFactorAuth\Providers;

use Illuminate\Support\ServiceProvider;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutes();
        $this->publishesConfig();
    }

    /**
     * Load package routes.
     */
    private function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . "/../../routes/web.php");
    }

    /**
     * Load and publishes package configuration.
     */
    private function publishesConfig()
    {
        $this->publishes([
            __DIR__ ."/../../config/laravel-2fa.php" => config_path('laravel-2fa.php'),
        ], 'laravel-2fa-config');
    }
}

