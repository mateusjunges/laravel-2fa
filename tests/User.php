<?php

namespace Junges\TwoFactorAuth\Tests;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Junges\TwoFactorAuth\Traits\HasTwoFactorAuthentication;

/**
 * Class User.
 *
 * @property string two_factor_code
 */
class User extends Authenticatable
{
    use HasTwoFactorAuthentication;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'users';
}
