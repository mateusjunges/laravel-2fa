<?php

namespace Junges\TwoFactorAuth\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;

trait HasTwoFactorAuthentication
{
    /**
     * Generate a two factor auth code to the user.
     */
    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = Str::upper(Str::random(config('laravel-2fa.code_length', 8)));
        $this->two_factor_expires_at = now()->addMinutes(config('laravel-2fa.code_expires_in', 10));
        $this->save();
    }

    /**
     * Reset the two factor code.
     */
    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    /**
     * Returns the expiration date of the user two factor code.
     * @return Carbon
     */
    public function getTwoFactorExpiration()
    {
        return Carbon::parse($this->two_factor_expires_at, config('app.timezone'));
    }
}
