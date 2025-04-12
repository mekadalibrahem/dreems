<?php

//  public function withoit class 

use App\Core\Views\View;
use App\Core\Helper\Helper;
use App\Core\Helper\Session;
use Symfony\Component\HttpFoundation\Response;


$GLOBALS['_flash'] = [];

// assert js or css files 
function assert_recources($file)
{
    try {

        $path = Helper::root_path() . 'public/' . $file;
        if (file_exists($path)) {
            return $path;
        } else {
            throw new Exception("FILE NOT FOUND {$path}");
        }
    } catch (\Throwable $th) {
        echo "Error: " . $th->getMessage(); // Show errors instead of hiding them
        return null;
    }
}
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function config($key, $default = null)
{
    return Helper::config($key, $default);
}

function view($view , $data = [])
{
    return View::view($view , $data);
}

function abort($code = 404)
{
    return new Response(
        file_get_contents(Helper::recources_path() .  'views/errors/404.php'),
        404,
        ['Content-Type' => 'text/html']
    );
}

function ec($value)
{
    echo htmlspecialchars($value);
}

function errors()
{
    $flash = $GLOBALS['_flash'];

    return $flash[Session::ERROR_KEY] ?? null;
}

function error($key)
{
    $errors = errors();
    return  $errors[$key] ?? false;
}
function has_error($key)
{
    return (bool) error($key);
}

function old($key, $default = '')
{
    return Session::getOld($key, $default);
}
function flashing()
{
    $GLOBALS['_flash'] = Session::getFlash() ?: [];
}
function flash_session($key)
{
    return $GLOBALS['_flash'][$key] ?? null;
}

function flash_has($key)
{
    return !empty($GLOBALS['_flash'][$key]);
}

function redirect($path, $data = [])
{
    // Append data as query strings if provided
    if (!empty($data)) {
        $query = http_build_query($data);
        $path .= (strpos($path, '?') === false ? '?' : '&') . $query;
    }
    
    // Perform redirect
    header('Location: ' . $path);
    exit;
}
function back()
{
    return  $_SERVER['HTTP_REFERER'] ?? '/';
}
