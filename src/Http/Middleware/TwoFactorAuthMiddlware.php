<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (Auth::check() and $user->two_factor_code) {
            if ($user->two_factor_expires_at->lt(now())) {
                $user->resetTwoFactorCode();
                Auth::logout();
                return redirect()
                    ->route('login')
                    ->withMessage('Your two factor code has been expired. Please, login again.');
            }
            if ($request->is('two_factor_code*')) {
                return redirect()->route('two_factor_code.verify');
            }
        }
        return $next($request);
    }
}
