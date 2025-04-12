<?php

namespace App\Core\Controllers;

use App\Core\Authentication\Auth;
use App\Core\Helper\Session;
use App\Core\Traits\SaveOldTraits;

class Controller
{
    use SaveOldTraits;

    /**
     * if user not authed redirect him to login page
     * 
     * @return void
     */
    public  function authed($redirectTo = '/admin/login')
    {
      
        // TODO move it to middleware 
        if (!Auth::user()) {
            redirect($redirectTo);
        }
    }
}
