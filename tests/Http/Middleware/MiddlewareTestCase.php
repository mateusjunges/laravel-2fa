<?php

namespace Junges\TwoFactorAuth\Tests\Http\Middleware;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Junges\TwoFactorAuth\Http\Middleware\TwoFactorAuthMiddleware;
use Junges\TwoFactorAuth\Tests\TestCase;

class MiddlewareTestCase extends TestCase
{
    /**
     * @var TwoFactorAuthMiddleware
     */
    public $twoFactorMiddleware;

    /**
     * Set up test.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->twoFactorMiddleware = new TwoFactorAuthMiddleware();

        Route::any('login', ['as' => 'login']);
        Route::any('protected', ['as' => 'protected'])->middleware('two_factor_auth');
    }

    /**
     * Execute the specified middleware.
     *
     * @param $middleware
     * @param $parameter
     *
     * @return int
     */
    protected function execMiddleware($middleware, $parameter = null)
    {
        try {
            return $middleware->handle(new Request(), function () {
                return (new Response())->setContent('<html></html>');
            }, $parameter)->status();
        } catch (Exception $exception) {
            return $exception->getCode();
        }
    }
}
