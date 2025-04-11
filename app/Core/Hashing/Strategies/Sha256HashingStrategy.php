<?php

namespace App\Core\Hashing\Strategies;

class  Sha256HashingStrategy implements HashingStrategy
{
    public function hash($value):string 
    {
        return hash('sha256', $value);
    }

    public function verify($value, $hashedValue):bool 
    {
        return hash('sha256', $value) === $hashedValue;
    }
}
