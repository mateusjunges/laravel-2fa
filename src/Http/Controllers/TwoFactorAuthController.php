<?php

namespace Junges\TwoFactorAuth\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Junges\TwoFactorAuth\Events\TwoFactorCodeConfirmed;
use Junges\TwoFactorAuth\Events\TwoFactorCodeResent;
use Junges\TwoFactorAuth\Http\Requests\TwoFactorAuthRequest;
use Junges\TwoFactorAuth\Notifications\TwoFactorCode;

class TwoFactorAuthController
{
    /**
     * Returns the two factor code verification view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (auth()->check() && !empty(auth()->user()->two_factor_code)) {
            return view('laravel2fa::verify-two-factor-auth');
        }

        return redirect()->back();
    }

    /**
     * Verify the two factor code.
     *
     * @param TwoFactorAuthRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TwoFactorAuthRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($request->input('two_factor_code') === $user->two_factor_code) {
            $user->resetTwoFactorCode();

            event(new TwoFactorCodeConfirmed($user));

            $redirectTo = config('laravel-2fa.redirect_to_route', 'home');

            return redirect()->route($redirectTo);
        }

        return redirect()
            ->back()
            ->withErrors([
                'two_factor_code' => 'The two factor code entered is invalid.',
            ]);
    }

    /**
     * Resend a user two factor code.
     */
    public function resend()
    {
        $user = Auth::user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        event(new TwoFactorCodeResent($user));

        return redirect()->back()->withMessage('Your two factor code have been resent. Check your email.');
    }
}
