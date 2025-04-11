<?php

namespace App\Core\Hashing;

use App\Core\Hashing\Strategies\HashingStrategy;
use App\Core\Hashing\Strategies\HashStrategyFactory;
use InvalidArgumentException;

class Hash
{



    // Private constructor to prevent direct instantiation
    private function __construct() {}

    public static function hash(string $password): string
    {

        if (empty($password)) {
            throw new InvalidArgumentException('Password cannot be empty.');
        }

        $strategy = HashStrategyFactory::get_instance();
        return   $strategy->hash($password);
    }

    public static function verify(string $password, string $hash): bool
    {
        if (empty($password) || empty($hash)) {
            throw new InvalidArgumentException('Password and hash cannot be empty.');
        }
        $strategy = HashStrategyFactory::get_instance();
        return $strategy->verify($password, $hash);
    }
}
