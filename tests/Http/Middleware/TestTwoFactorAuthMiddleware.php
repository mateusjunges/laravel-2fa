<?php

namespace Junges\TwoFactorAuth\Tests\Http\Middleware;

class TestTwoFactorAuthMiddleware extends MiddlewareTestCase
{
    public function test_it_deny_access_to_users_with_wrong_two_factor_code()
    {

    }

    public function test_it_allow_access_to_routes_not_protected_by_two_factor_middleware()
    {

    }

    public function test_it_deny_access_to_not_authenticated_users()
    {

    }
}
