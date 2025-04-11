<?php

namespace App\Core\Helper\Rules;

abstract class Rule
{
    protected  static $name;
    protected  static $error;
    abstract static public function check($data): bool;


    public  abstract static function getName();

    public abstract static function getError();
}
