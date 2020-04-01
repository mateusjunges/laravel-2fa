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
     * Handle successfully authenticated user.
     * @param Request $request
     * @param $user
     */
    public function authenticated(Request $request, $user)
    {
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }
}
