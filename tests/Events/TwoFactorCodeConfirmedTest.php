<?php

namespace Junges\TwoFactorAuth\Tests\Events;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Junges\TwoFactorAuth\Events\TwoFactorCodeConfirmed;
use Junges\TwoFactorAuth\Http\Controllers\TwoFactorAuthController;
use Junges\TwoFactorAuth\Http\Requests\TwoFactorAuthRequest;
use Junges\TwoFactorAuth\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorCodeConfirmedTest extends TestCase
{
    public function test_confirm_two_factor_code_method_dispatch_code_confirmed_event()
    {
        Auth::login($this->user);

        Event::fake();

        Route::any('home', ['as' => 'home'])->middleware('two_factor_auth');

        $code = Str::upper(Str::random(8));

        $this->user->two_factor_code = $code;
        $this->user->save();

        $request = TwoFactorAuthRequest::create('/two-factor-code/verify', 'POST', [
            'two_factor_code' => $code,
        ]);

        $controller = new TwoFactorAuthController();

        $response = $controller->store($request);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());

        Event::assertDispatched(TwoFactorCodeConfirmed::class, function ($event) {
            return $this->user->id === $event->user->id;
        });
    }
}
