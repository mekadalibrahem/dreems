<?php 
namespace App\Core\Hashing\Strategies;

interface HashingStrategy {
    public function hash(string $password): string;
    public function verify(string $password, string $hash): bool;
}