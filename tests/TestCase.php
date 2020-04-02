<?php

namespace Junges\TwoFactorAuth\Tests;
use Junges\TwoFactorAuth\Providers\TwoFactorAuthServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{

    public function setUp() : void
    {
        parent::setUp();

        $this->configureDatabase($this->app);

        (new TwoFactorAuthServiceProvider($this->app))->boot();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    public function getPackageProviders($app)
    {
        return [
            TwoFactorAuthServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    public function getEnvironmentSetup($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('views.path', [__DIR__.'/resources/views']);
    }

    /**
     * @param $app
     */
    public function configureDatabase($app)
    {
        include_once __DIR__ . "/../database/migrations/2020_04_01_134109_laravel_2fa_fields.php";

        (new \Laravel2faFields())->up();
    }
}
