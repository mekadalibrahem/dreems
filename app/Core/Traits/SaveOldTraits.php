<?php

namespace App\Core\Traits;

use App\Core\Helper\Session;

trait SaveOldTraits
{

    public function saveOld($request)
    {
        foreach ($request as $key => $value) {

            Session::old($key, $value);
        }
    }
}
