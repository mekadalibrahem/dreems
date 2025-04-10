<?php

use App\Helper\Helper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Bootstrap the application and get the router and handler
$bootstrap = require __DIR__ . '/../app/bootstrap/kernel.php';
$router = $bootstrap['router'];
$handler = $bootstrap['handler'];

// Dispatch the request
$request = Request::capture();

try {

    if (Kernel::isRouteRegistered()) {
        $response = $router->dispatch($request);
        $response->send();
    } else {
        // Create a 404 response manually
        $response = new Response(
            file_get_contents(Helper::recources_path() .  '/views/errors/404.php'), // Load a static HTML file
            404,
            ['Content-Type' => 'text/html']
        );
        $response->send();
    }
} catch (Throwable $e) {
    $response = $handler->render($request, $e);
    $response->send();
}
