<?php

namespace App\Core\Helper;

class Session
{
    public const FLASH_KEY = '_flash';
    public const ERROR_KEY = '_errors';
    public const OLD_KEY = '_old';

    /**
     * Ensure session is started
     */
    private static function ensureStarted(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Store a value in session
     */
    public static function put(string $key, $value): void
    {
        self::ensureStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieve a value from session
     */
    public static function get(?string $key = null, $default = null)
    {
        self::ensureStarted();
        return $key === null ? ($_SESSION ?? $default) : ($_SESSION[$key] ?? $default);
    }

    /**
     * Store a flash value
     */
    public static function flash(string $key, $value): void
    {
        self::ensureStarted();
        $_SESSION[self::FLASH_KEY][$key] = $value;
    }

    /**
     * Store an error message
     */
    public static function error(string $key, $value): void
    {
        self::ensureStarted();
        $_SESSION[self::FLASH_KEY][self::ERROR_KEY][$key] = $value;
    }

    /**
     * Store old input value
     */
    public static function old(string $key, $value): void
    {
        self::ensureStarted();
        $_SESSION[self::OLD_KEY][$key] = $value;
    }

    /**
     * Check if a key exists and has a value
     */
    public static function has(string $key): bool
    {
        self::ensureStarted();
        return isset($_SESSION[$key]) && !empty($_SESSION[$key]);
    }

    /**
     * Remove flash messages
     */
    public static function unflash(): void
    {
        self::remove(self::FLASH_KEY);
    }

    /**
     * Remove a specific key from session
     */
    public static function remove(string $key): void
    {
        self::ensureStarted();
        unset($_SESSION[$key]);
    }

    /**
     * Destroy entire session
     */
    public static function destroy(): void
    {
        self::ensureStarted();
        session_destroy();
    }

    /**
     * Get old input value
     */
    public static function getOld(string $key, $default = ''): mixed
    {
        self::ensureStarted();
        return $_SESSION[self::OLD_KEY][$key] ?? $default;
    }

    /**
     * Get all error messages
     */
    public static function getErrors(): array|false
    {
        self::ensureStarted();
        return $_SESSION[self::FLASH_KEY][self::ERROR_KEY] ?? false;
    }

    /**
     * Get all flash messages
     */
    public static function getFlash(): array|false
    {
        self::ensureStarted();
        return $_SESSION[self::FLASH_KEY] ?? false;
    }
}