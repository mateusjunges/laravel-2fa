<?php

namespace Junges\TwoFactorAuth\Traits;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Trait HasTwoFactorAuthentication
 */
trait HasTwoFactorAuthentication
{
    use AuthenticatesUsers;

    /**
     * Handle successfully authenticated user.
     * @param Request $request
     * @param $user
     */
    public function authenticated(Request $request, $user)
    {   dd('ok');
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }
}
