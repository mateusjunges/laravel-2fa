<?php

use Illuminate\Support\Facades\Route;

Route::get(
    'two-factor-code/resend',
    '\Junges\TwoFactorAuth\Http\Controllers\TwoFactorAuthController@resend'
)->name('two_factor_code.resend');

Route::get(
    'two-factor-code/verify',
    '\Junges\TwoFactorAuth\Http\Controllers\TwoFactorAuthController@index'
)->name('two_factor_code.verify');

Route::post(
    'two-factor-code/verify',
    '\Junges\TwoFactorAuth\Http\Controllers\TwoFactorAuthController@store'
)->name('two_factor_code.verify.store');
