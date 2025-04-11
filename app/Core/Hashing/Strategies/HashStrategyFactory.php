<?php

namespace App\Core\Hashing\Strategies;

use Symfony\Component\Routing\Exception\InvalidParameterException;

class HashStrategyFactory
{

    public const ALLOWED_STARTEGIES = [
        'argon2',
        'bcrypt'
    ];



    public const DEFAULT_STRATEGIES = 'bcrypt';
    public  static function get_instance()
    {
        $type = config('app.hash.startegy', self::DEFAULT_STRATEGIES);
        if (in_array($type, self::ALLOWED_STARTEGIES)) {
            switch ($type) {
                case 'argon2':
                    return new Argon2HashingStrategy();
                case 'bcrypt':
                    return new BcryptHashingStrategy();
                default:
                    return new BcryptHashingStrategy();
            }
        } else {
            throw new InvalidParameterException("FAILD GET HASH_STRATEGY INSTANCE : INVALID STARTEGY TYPE GIVEN  {$type}  ALLWOED TYPES IS :  " . implode(', ', self::ALLOWED_STARTEGIES));
        }
    }
}
