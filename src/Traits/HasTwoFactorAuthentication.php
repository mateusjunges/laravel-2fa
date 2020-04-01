<?php

namespace Junges\TwoFactorAuth\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Trait HasTwoFactorAuthentication
 * @package Junges\TwoFactorAuth\Traits
 * @property string two_factor_code
 */
trait HasTwoFactorAuthentication
{
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

    /**
     * Generate a two factor auth code to the user.
     */
    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = Str::random(config('laravel-2fa.code_length', 8));;
        $this->two_factor_expires_at = now()->addMinutes(config('laravel-2fa.code_expires_in', 10));
        $this->save();
    }


}
