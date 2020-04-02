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
        $this->loadViews();
        $this->publishesAssets();
        $this->loadMigrations();
    }

    /**
     * Load package routes.
     */
    private function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Load and publishes package configuration.
     */
    private function publishesConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/laravel-2fa.php' => config_path('laravel-2fa.php'),
        ], 'laravel-2fa-config');
    }

    /**
     * Publishes package assets.
     */
    public function publishesAssets()
    {
        $this->publishes([
            __DIR__.'/../../public' => public_path('vendor/junges/laravel-2fa'),
        ], 'laravel-2fa-assets');
    }

    /**
     * Load package views.
     */
    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laravel2fa');
    }

    public function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
