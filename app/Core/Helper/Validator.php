<?php

namespace App\Core\Helper;

use App\Core\Helper\Rules\Required;
use Exception;

class Validator
{
    public static $rules = [
        'required' => Required::class,
    ];
    public static function validate($rule, $errorKey, $data)
    {
        $valid_rule = self::$rules[$rule] ?? false;
       
        if ($valid_rule) {
            if ($valid_rule::check($data)) {
                return true;
            } else {
                Session::error($errorKey, $valid_rule::getError());
                return false;
            }
        } else {
            throw new Exception("Rule not found");
        }
    }
}
