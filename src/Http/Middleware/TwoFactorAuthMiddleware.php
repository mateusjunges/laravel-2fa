<?php

namespace Junges\TwoFactorAuth\Http\Middleware;

use App\User;
use Closure;

class TwoFactorAuthMiddleware
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
        /** @var User $user */
        $user = auth()->user();

        if (auth()->check() && $user->two_factor_code) {

            if ($user->getTwoFactorExpiration()->lt(now())) {

                $user->resetTwoFactorCode();

                auth()->logout();

                return redirect()
                    ->route('login')
                    ->withMessage('Your two factor code has been expired. Please, login again.');
            }

            if (! $request->is('two_factor_code*')) {
                return redirect()->route('two_factor_code.verify');
            }

        }
        return $next($request);
    }
}
