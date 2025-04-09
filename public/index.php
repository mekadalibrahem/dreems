<?php

use Illuminate\Http\Request;

// Bootstrap the application and get the router
$router = require __DIR__ . '/../app/bootstrap/kernel.php';

// Dispatch the request
$request = Request::capture();
$response = $router->dispatch($request);

// Send the response
$response->send();