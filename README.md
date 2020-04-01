# Laravel 2fa

A simple two factor authentication for laravel applications.
<p align="center">
    <a href="https://packagist.org/packages/mateusjunges/laravel-2fa" target="_blank"><img src="https://poser.pugx.org/mateusjunges/laravel-2fa/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/mateusjunges/laravel-2fa" target="_blank"><img src="https://poser.pugx.org/mateusjunges/laravel-2fa/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/mateusjunges/laravel-2fa" target="_blank"><img src="https://poser.pugx.org/mateusjunges/laravel-2fa/license.svg" alt="License"></a>
    <a href="https://github.styleci.io/repos/175907190" target="_blank"><img src="https://github.styleci.io/repos/175907190/shield?style=flat"></a>    
    <a href="https://github.com/mateusjunges/laravel-2fa/actions?query=workflow%3A%22Continuous+Integration%22" target="_blank">
        <img src="https://github.com/mateusjunges/laravel-2fa/workflows/Continuous%20Integration/badge.svg">
    </a>
</p>


## Installation

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

After installing the package, you must run `php artisan migrate` to add the two factor authentication fields
to your `users` table.

It will add the following columns to your database table:

```text
|-------- users --------|
|    two_factor_code    |
| two_factor_expires_at |
|-----------------------|
```

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


