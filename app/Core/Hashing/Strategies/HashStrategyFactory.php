<?php

namespace App\Core\Hashing\Strategies;

use Symfony\Component\Routing\Exception\InvalidParameterException;

class HashStrategyFactory
{

    public const ALLOWED_STARTEGIES = [
        'argon2',
        'bcrypt',
        'sha256'
    ];
    protected static $strategy = null;


    public const DEFAULT_STRATEGIES = 'sha256';
    public  static function get_instance()
    {
        if (self::$strategy == null) {
            $type = config('app.hash.startegy', self::DEFAULT_STRATEGIES);
            if (in_array($type, self::ALLOWED_STARTEGIES)) {
                switch ($type) {
                    case 'argon2':
                        self::$strategy =  new Argon2HashingStrategy();
                        break;
                    case 'bcrypt':
                        self::$strategy = new  BcryptHashingStrategy();
                        break;
                    case 'sha256' : 
                        selF::$strategy = new Sha256HashingStrategy();
                    default:
                        self::$strategy = new Sha256HashingStrategy();
                        break;
                }

            } else {
                throw new InvalidParameterException("FAILD GET HASH_STRATEGY INSTANCE : INVALID STARTEGY TYPE GIVEN  {$type}  ALLWOED TYPES IS :  " . implode(', ', self::ALLOWED_STARTEGIES));
            }

        }
        return self::$strategy;
    }
}
