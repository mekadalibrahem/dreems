<?php

namespace App\Core\Authentication;

use App\Core\Hashing\Hash;
use App\Core\Helper\Session;
use App\Models\User;

class Auth
{

    private static ?User $user = null;



    public static function check()
    {
        return self::$user !== null;
    }

    public static function user()
    {
        return self::$user;
    }

    public static function login(array $credentials)
    {
        // extract password value 
        $password = $credentials['password'] ?? null;
        unset($credentials['password']);
        // cardinat [key=> value , password => password_value]
        $user = User::where($credentials)->first();
        if ($user && Hash::verify($password, $user->password)) {
            Session::put(config('session.auth_session_key', 'user_id'),  $user->id);
            return true;
        } else {
            return false;
        }
    }

    public static function logout()
    {
        self::$user = null;
        Session::remove(config('session.auth_session_key'));
        Session::destroy();
    }
}
