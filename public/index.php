<?php

use Illuminate\Http\Request;

// Bootstrap the application and get the router and handler
$bootstrap = require __DIR__ . '/../app/bootstrap/kernel.php';
$router = $bootstrap['router'];
$handler = $bootstrap['handler'];

// Dispatch the request
$request = Request::capture();
try {
    $response = $router->dispatch($request);
    $response->send();
} catch (Throwable $e) {
    $response = $handler->render($request, $e);
    $response->send();
}