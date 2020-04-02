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
    'tables' => [
        'users' => 'users',
    ],

    /*
   |--------------------------------------------------------------------------
   | Two factor code length
   |--------------------------------------------------------------------------
   | Specify the length of your two factor code.
   |
    */
    'code_length' => 8,

    /*
    |--------------------------------------------------------------------------
    | Two factor code expiration time
    |--------------------------------------------------------------------------
    | Specify the duration of your two factor code in minutes.
    |
    */
    'code_expires_in' => 10,

    /*
     |--------------------------------------------------------------------------
     | Redirect to route
     |--------------------------------------------------------------------------
     | Specify the route which users should be redirected to after successfully confirming
     | the two factor auth code.
     |
      */
    'redirect_to_route' => 'home',
];
