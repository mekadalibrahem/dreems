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

function view($view)
{
    return View::view($view);
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

function old($key, $default=''){
    return Session::getOld($key, $default);
} 
function flashing(){
    $GLOBALS['_flash'] = Session::getFlash();
    Session::unflash();
}
function get_flash(){
    
}