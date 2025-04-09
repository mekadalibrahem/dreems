<?php

namespace App\Helper;

class Helper
{


    /**
     * Retrieve a configuration value from the specified configuration file.
     *
     * This method allows fetching a configuration value by specifying either 
     * a string or an array as the key. If the key is a string, it is expected 
     * to be in the format "file.key", where "file" is the configuration file 
     * name (without extension) and "key" is the key within that file. If the 
     * key is an array, the first element is the file name, and the subsequent 
     * elements are keys used to drill down into the configuration array.
     *
     * @param string|array $key The configuration key or array of keys.
     * @param mixed $default The default value to return if the configuration key is not found.
     * 
     * @return mixed The configuration value or the default value if the key does not exist.
     */

    public static function config(string|array $key, $default = null)
    {
        $path = self::config_path();

        if (is_array($key)) {
            $file = $key[0];
            array_shift($key);
            $config = require $path . "{$file}.php";

            foreach ($key as $k) {
                if (isset($config[$k])) {
                    $config = $config[$k];
                } else {
                    return $default;
                }
            }

            return $config ??  $default;
        }

        $file = explode('.', $key)[0];
        $key = explode('.', $key)[1] ?? null;

        $config = require $path . "{$file}.php";

        if (is_null($key)) {
            return $config ??  $default;
        }

        return $config[$key] ??  $default;
    }
    /**
     * Dumps the given variable and ends script execution.
     *
     * This function is a convenient wrapper around var_dump() that immediately
     * ends script execution after dumping the variables. This is useful for
     * debugging purposes when you want to quickly inspect a variable without
     * having to manually inspect the output and then restart the script.
     *
     * @param mixed $value The value to be dumped and inspected.
     */
    public static function dd(...$value)
    {

        echo "<pre>";
        var_dump(...$value);
        echo "</pre>";
    }


    /**
     * Check if the current request URI matches the given URI.
     *
     * @param string $uri The URI to compare against the current request URI.
     * @return bool True if the current request URI matches the given URI, false otherwise.
     */

    public static function is_uri($uri): bool
    {
        return $_SERVER['REQUEST_URI'] === $uri;
    }

    /**
     * Get the root path of the application.
     *
     * @return string The root directory path.
     */

    public static function root_path(): string
    {
        return   __DIR__ . "/../../";
    }


    /**
     * Get the path to the config directory.
     *
     * @return string The path to the config directory.
     */
    public static function config_path(): string
    {
        return self::root_path() . "config/";
    }


    public static function recources_path(): string
    {
        return self::root_path() . 'recources/';
    }

    public static function views_path(): string
    {
        return self::recources_path() . "views/";
    }
}
