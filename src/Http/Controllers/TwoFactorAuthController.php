<?php

namespace Junges\TwoFactorAuth\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Junges\TwoFactorAuth\Http\Requests\TwoFactorAuthRequest;
use Junges\TwoFactorAuth\Notifications\TwoFactorCode;

class TwoFactorAuthController
{
    public function index()
    {
        return view('laravel2fa::verify-two-factor-auth');
    }

    public function store(TwoFactorAuthRequest $request)
    {
        $user = Auth::user();

        if ($request->input('two_factor_code') === $user->two_factor_code) {

            $user->resetTwoFactorCode();

            $redirectTo = config('laravel-2fa.redirect_to_route');

            return redirect()->route($redirectTo);
        }
        return redirect()
            ->back()
            ->withErrors([
                'two_factor_code' => 'The two factor code entered is invalid.'
            ]);
    }

    public function resend()
    {
        $user = Auth::user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }
}
