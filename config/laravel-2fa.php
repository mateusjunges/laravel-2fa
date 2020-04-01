<?php

return [
    "tables" => [
        "users" => "users",
    ],

    "models" => [
        "user" => \App\User::class,
    ],

    "code_length" => 8,
    "code_expires_in" => 10,
    "redirect_to_route" => "home"
];
