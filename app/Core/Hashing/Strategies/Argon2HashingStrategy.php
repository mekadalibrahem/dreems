<?php

namespace App\Core\Hashing\Strategies;

use RuntimeException;

class Argon2HashingStrategy implements HashingStrategy
{
    private array $options;

    public function __construct(array $options = [])
    {
        $this->options = array_merge([
            'memory_cost' => 65536,
            'time_cost' => 4,
            'threads' => 2,
        ], $options);
    }

    public function hash(string $password): string
    {
        $hash = password_hash($password, PASSWORD_ARGON2ID, $this->options);

        if ($hash === false) {
            throw new RuntimeException('Failed to hash password using Argon2.');
        }

        return $hash;
    }

    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
