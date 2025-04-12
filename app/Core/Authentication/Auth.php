<?php

namespace App\Core\Authentication;

use App\Core\Hashing\Hash;
use App\Core\Helper\Session;
use App\Models\User;

class Auth
{


    public static function user()
    {
        $user_id = Session::get(config('auth.auth_session_key', 'user_id'));
        if ($user_id) {
            $user = User::find($user_id);
            return $user;
        } else {
            return null;
        }
    }

    public static function login(array $credentials)
    {
        // extract password value 
        $password = $credentials['password'] ?? null;
        unset($credentials['password']);
        // cardinat [key=> value , password => password_value]
        $user = User::where($credentials)->first();
        if ($user && Hash::verify($password, $user->password)) {
            Session::put(config('auth.auth_session_key', 'user_id'),  $user->id);

            return true;
        } else {
            return false;
        }
    }

    public static function logout()
    {

        Session::remove(config('auth.auth_session_key'));
        Session::destroy();
    }
}
