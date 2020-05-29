<?php

namespace App\Src;

use App\User;
use App\Events\AutoUserRegistered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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

    public static function deleteUser($user_id)
    {
        User::destroy($user_id);
        self::deleteUserDirs($user_id);
    }

    public static function deleteUserDirs($user_id)
    {
        $search_dir = "/users_data\/{$user_id}$/";
        $events_directories = Storage::getAdapter()->getPathPrefix() . "events";

        function delete_dirs($events_directories, $search_dir)
        {
            $subDir = array();
            $directories = array_filter(glob($events_directories), 'is_dir');
            $subDir = array_merge($subDir, $directories);
            foreach ($directories as $directory) {
                if (preg_match($search_dir, $directory)) {
                    exec("rm -rf " . $directory);
                }
                $subDir = array_merge($subDir, delete_dirs($directory . '/*', $search_dir));
            }
            return $subDir;
        }
        delete_dirs($events_directories, $search_dir);
    }
}
