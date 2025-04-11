<?php 

namespace App\Controllers;

use App\Core\Controllers\Controller;

class AdminController extends Controller {

    public function create(){
        return view('admin/dashboard');
    }


}

