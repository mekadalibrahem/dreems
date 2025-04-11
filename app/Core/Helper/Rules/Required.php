<?php

namespace App\Core\Helper\Rules;

class Required extends Rule
{
    protected static $name = 'required';
    protected static $error =  'This field is required';
    public static function check($data): bool
    {
        if (empty($data)) {
            return  false;
        } else {
            return true;
        }
    }
    public static function getName()
    {
        return  self::$name;
    }

    public static function getError()
    {
        return self::$error;
    }
}
