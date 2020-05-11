<?php

namespace App\Src;

use App\User;
use App\Events\AutoUserRegistered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserHandler
{

    public static function createUserByEmail($email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            return $user;
        }

        $password = Str::random(8);
        $user = User::create(
            [
                'login' => $email,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now()
            ]
        );

        event(new AutoUserRegistered($user, $password));
        return $user;
    }
}
