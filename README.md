# Laravel 2fa

A simple two factor authentication for laravel applications.
<p align="center">
    <a href="https://packagist.org/packages/mateusjunges/laravel-2fa" target="_blank"><img src="https://poser.pugx.org/mateusjunges/laravel-2fa/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/mateusjunges/laravel-2fa" target="_blank"><img src="https://poser.pugx.org/mateusjunges/laravel-2fa/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/mateusjunges/laravel-2fa" target="_blank"><img src="https://poser.pugx.org/mateusjunges/laravel-2fa/license.svg" alt="License"></a>
    <a href="https://github.styleci.io/repos/252182910" target="_blank"><img src="https://github.styleci.io/repos/252182910/shield?style=flat"></a>    
    <a href="https://github.com/mateusjunges/laravel-2fa/actions?query=workflow%3A%22Continuous+Integration%22" target="_blank">
        <img src="https://github.com/mateusjunges/laravel-2fa/workflows/Continuous%20Integration/badge.svg">
    </a>
</p>


- [Installation](#installation)
    - [Require via composer](#require-this-package-via-composer)
    - [Update database](#update-database-with-php-artisan-migrate)
    - [Replace authentication trait on LoginController](#replace-authenticatesusers-trait-on-logincontroller)
    - [Publish package config](#publish-package-config)
    - [Publish package assets](#publish-package-assets)
- [Usage](#usage)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)



## Installation

### Require this package via composer
To get started with Laravel 2FA, use Composer to add the package to your project's dependencies:

```bash
composer require mateusjunges/laravel-2fa
```
Or add this line in your composer.json, inside of the require section:
```bash
{
    "require": {
        "mateusjunges/laravel-2fa": "^1.0",
    }
}
```
then run `composer install`.

### Update database with php artisan migrate
After installing the package, you must run `php artisan migrate` to add the two factor authentication fields
to your `users` table.

It will add the following columns to your database table:

```text
|-------- users --------|
|    two_factor_code    |
| two_factor_expires_at |
|-----------------------|
```

### Replace AuthenticatesUsers trait on LoginController
After that, open your `app\Http\Controllers\Auth\LoginController` file and replace the
`AuthenticatesUsers` trait with the `AuthenticateUsersWithTwoFactor`, provided by this package.

Basically, it overrides the `authenticated` method on `AuthenticatesUsers`:


```php
trait AuthenticateUsersWithTwoFactor
{
    use AuthenticatesUsers;

    /**
     * The user has been successfully authenticated.
     * @param Request $request
     * @param $user
     */
    public function authenticated(Request $request, $user)
    {
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }
}
```

### Publish package config

To publish the package configuration, you can use the following command:

```shell script
php artisan vendor:publish --provider="Junges\TwoFactorAuth\TwoFactorAuthServiceProvider" --tag="laravel-2fa-config"
```

After published, this is how `config/laravel-2fa.php` will looks like:

```php
<?php

return [
    /*
   |--------------------------------------------------------------------------
   | Tables
   |--------------------------------------------------------------------------
   | Specify the basics authentication tables that you are using.
   | Once you required this package, the following tables are
   | created/modified by default when you run the command
   |
   | php artisan migrate
   |
    */
    "tables" => [
        "users" => "users",
    ],
   
    /*
   |--------------------------------------------------------------------------
   | Two factor code length
   |--------------------------------------------------------------------------
   | Specify the length of your two factor code.
   |
    */
    "code_length" => 8,

     /*
    |--------------------------------------------------------------------------
    | Two factor code expiration time
    |--------------------------------------------------------------------------
    | Specify the duration of your two factor code in minutes.
    |
    */
    "code_expires_in" => 10,

     /*
     |--------------------------------------------------------------------------
     | Redirect to route
     |--------------------------------------------------------------------------
     | Specify the route which users should be redirected to after successfully confirming
     | the two factor auth code.
     |
      */
    "redirect_to_route" => "home"
];
```

### Publish package assets
This package uses a custom view to confirm the two factor code.
You need to publish the package assets to that view with the following command:

```shell script
php artisan vendor:publish --provider="Junges\TwoFactorAuth\TwoFactorAuthServiceProvider" --tag="laravel-2fa-assets" 
```

## Usage

To start using this package, you need to configure your email settings in `.env` file. This is an example config:

```text
MAIL_MAILER=your_mailer
MAIL_HOST=your_mailer_host
MAIL_PORT=2525
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=your_mail@your_domain.com
MAIL_FROM_NAME="${APP_NAME}"
```


Now, you need to register the `two_factor` middleware in your `app/Http/Kernel.php` file. Add it to the `routeMiddleware` array:
```php
protected $routeMiddleware = [
    ...
    'two_factor_auth' => TwoFactorAuthMiddleware::class
];
```

After that, you just need to protect your routes with the `two_factor` middleware:

```php
Route::middleware('two_factor_auth')->group(function() {
    // Your routes here
});
```

### Events

This package dispatches events for two factor code confirmed and two factor code resent actions.

You can listen to these events in your `EventServiceProvider`:

```php
protected $listen = [
    \Junges\TwoFactorAuth\Events\TwoFactorCodeConfirmed::class => [
        //Your listeners here
    ],
    \Junges\TwoFactorAuth\Events\TwoFactorCodeResent::class => [
        // Your listeners here
    ]
];
```

With your routes protected, your users must confirm the two factor authentication code, which will be sent
via email after they login with correct credentials.

# Contributing
Thank you for considering contributing for the Laravel Invite Codes package! The contribution guide can be found [here](https://github.com/mateusjunges/laravel-2fa/blob/master/CONTRIBUTING.md).

# Tests
Run `composer test` to test this package.

# Credits
- [Mateus Junges](https://github.com/mateusjunges)
- [Quick Admin Panel](https://quickadminpanel.com/)

# License
The Laravel 2FA package is open-sourced software licenced under the [MIT License](https://opensource.org/licenses/MIT). Please see [the License File](https://github.com/mateusjunges/laravel-2fa/blob/master/LICENSE) for more information.
