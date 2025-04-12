<?php

namespace App\Controllers\Auth;

use App\Core\Authentication\Auth;
use App\Core\Controllers\Controller;
use App\Core\Helper\Session;
use App\Core\Helper\Validator;

class LoginController extends Controller
{

    public function create()
    {
        return view('auth/login');
    }


    public function store()
    {

        $request_data = $_REQUEST;
        $this->saveOld($request_data);
        Validator::validate($request_data, [
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::login($request_data)) {
            redirect('/admin/dashboard');
        } else {
            Session::error('invlaid_credentials', "اسم المستخدم او كلمة المرور غير صحيحة");
            redirect(back());
        }
    }

    public function destroy()
    {
        Auth::logout();
        redirect('/');
    }
}
