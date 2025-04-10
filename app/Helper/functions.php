<?php

//  public function withoit class 

use App\Core\Views\View;
use App\Helper\Helper;
use Symfony\Component\HttpFoundation\Response;


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

function config($key, $default = null)
{
    return Helper::config($key, $default);
}

function view($view){
    return View::view($view);
}

function abort($code = 404 ){
    return new Response(
        file_get_contents(Helper::recources_path() .  '/views/errors/404.php'), 
        404,
        ['Content-Type' => 'text/html']
    );
}