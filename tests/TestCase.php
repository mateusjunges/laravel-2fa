<?php

namespace Junges\TwoFactorAuth\Tests;

use Illuminate\Database\Schema\Blueprint;
use Junges\TwoFactorAuth\Providers\TwoFactorAuthServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /*** @var User */
    public $user;

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->configureDatabase($this->app);

        $this->createTestUser();

        (new TwoFactorAuthServiceProvider($this->app))->boot();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
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
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->softDeletes();
        });

        include_once __DIR__.'/../database/migrations/2020_04_01_134109_laravel_2fa_fields.php';

        (new \Laravel2faFields())->up();
    }

    /**
     * Create a test user on database.
     */
    public function createTestUser()
    {
        $this->user = User::create([
            'name' => 'Mateus Junges',
            'email' => 'mateus@junges.dev',
        ]);
    }
}
