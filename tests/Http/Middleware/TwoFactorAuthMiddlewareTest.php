<?php

namespace Junges\TwoFactorAuth\Tests\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;

class TestTwoFactorAuthMiddleware extends MiddlewareTestCase
{
    public function test_it_allow_access_to_routes_not_protected_by_two_factor_middleware()
    {
        $this->assertEquals(
            $this->execMiddleware(
                $this->twoFactorMiddleware,
                ""
            ),
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function test_it_deny_access_to_not_authenticated_users()
    {

    }
}
