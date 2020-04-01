<?php

namespace Junges\TwoFactorAuth\Traits;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Junges\TwoFactorAuth\Notifications\TwoFactorCode;

/**
 * Trait HasTwoFactorAuthentication
 */
trait AuthenticateUsersWithTwoFactor
{
    use AuthenticatesUsers;

    /**
     * The user has been successfully authenticated.
     * @param Request $request
     * @param $user
     */
    public function authenticated(Request $request, $user)
    {
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }
}
