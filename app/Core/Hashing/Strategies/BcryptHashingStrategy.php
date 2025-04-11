<?php
namespace App\Core\Hashing\Strategies;


use RuntimeException;

class BcryptHashingStrategy implements HashingStrategy
{
    private string $cost;

    public function __construct(string $cost = '12')
    {
        $this->cost = $cost;
    }

    public function hash(string $password): string
    {
        $options = ['cost' => $this->cost];
        $hash = password_hash($password, PASSWORD_BCRYPT, $options);

        if ($hash === false) {
            throw new RuntimeException('Failed to hash password using Bcrypt.');
        }

        return $hash;
    }

    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
