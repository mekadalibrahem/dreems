<?php

use App\Core\Helper\Session;
use App\Helper\Helper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Bootstrap the application and get the router and handler
$bootstrap = require __DIR__ . '/../app/Core/bootstrap/kernel.php';
$router = $bootstrap['router'];
$handler = $bootstrap['handler'];

// Dispatch the request
$request = Request::capture();

try {
    // Load flash messages into $GLOBALS['_flash']
    flashing();
    if (Kernel::isRouteRegistered()) {
        $response = $router->dispatch($request);
        $response->send();
    } else {
        // Create a 404 response manually
        $response = abort(404);
        $response->send();
    }
    // Clear flash messages *after* rendering the view
    Session::unflash();
} catch (Throwable $e) {
    $response = $handler->render($request, $e);
    $response->send();
    // Clear flash messages *after* rendering the view
    Session::unflash();
}
