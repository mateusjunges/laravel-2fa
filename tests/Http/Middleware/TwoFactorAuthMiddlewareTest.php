<?php

namespace Junges\TwoFactorAuth\Tests\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAuthMiddlewareTest extends MiddlewareTestCase
{
    public function test_it_does_not_allow_access_to_guest_users()
    {
        $this->assertEquals(
            Response::HTTP_FOUND,
            $this->execMiddleware(
                $this->twoFactorMiddleware
            )
        );
    }

    public function test_if_logged_in_user_with_two_factor_confirmed_can_access_protected_routes()
    {
        Auth::login($this->user);

        $this->assertEquals(
            Response::HTTP_OK,
            $this->execMiddleware(
                $this->twoFactorMiddleware
            )
        );
    }

    public function test_if_logged_in_user_without_two_factor_confirmed_can_not_access_protected_routes()
    {
        Auth::login($this->user);

        $this->user->two_factor_code = Str::upper(Str::random(8));
        $this->user->save();

        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $this->execMiddleware(
                $this->twoFactorMiddleware
            )
        );
    }
}
