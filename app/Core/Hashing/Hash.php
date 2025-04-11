<?php

namespace App\Core\Hashing;

use App\Core\Hashing\Strategies\HashingStrategy;
use App\Core\Hashing\Strategies\HashStrategyFactory;
use InvalidArgumentException;

class Hash
{
    private static ?Hash $instance = null;
    private HashingStrategy $strategy;

    // Private constructor to prevent direct instantiation
    private function __construct(HashingStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    // Get singleton instance
    private static function getInstance(): self
    {
        if (self::$instance === null) {
            // Default to Bcrypt if no strategy is provided
            $strategy = $strategy ?? HashStrategyFactory::get_instance();
            self::$instance = new self($strategy);
        }

        return self::$instance;
    }

    // Set a new hashing strategy
    // public function setStrategy(HashingStrategy $strategy): self
    // {
    //     $this->strategy = $strategy;
    //     return $this;
    // }

    // Hash a password
    public function hash_text(string $password): string
    {
        if (empty($password)) {
            throw new InvalidArgumentException('Password cannot be empty.');
        }

        return $this->strategy->hash($password);
    }

    // Verify a password against a hash
    public function verify_text(string $password, string $hash): bool
    {
        if (empty($password) || empty($hash)) {
            throw new InvalidArgumentException('Password and hash cannot be empty.');
        }

        return $this->strategy->verify($password, $hash);
    }

    public static function hash(string $password) : string {
        $instance = self::getInstance();
        return $instance->hash_text($password);
    }

    public static function verify(string $password , string $hash) : bool {
        $instance = self::getInstance();
        return $instance->verify($password , $hash);
    }
}
