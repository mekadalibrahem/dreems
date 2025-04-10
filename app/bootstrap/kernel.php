<?php

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . "/../Helper/functions.php";

use Dotenv\Dotenv;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\CallableDispatcher;
use Illuminate\Routing\Contracts\CallableDispatcher as CallableDispatcherContract;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Facade;
use App\Exceptions\Handler;

class Kernel
{
    private static $instance = null;

    public static function bootstrap()
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $container = new Container;

        $capsule = new Capsule;
        $capsule->addConnection(require __DIR__ . '/../../config/database.php');
        $capsule->setEventDispatcher(new Dispatcher($container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $events = new Dispatcher($container);
        $router = new Router($events, $container);

        $container->singleton(CallableDispatcherContract::class, function ($container) {
            return new CallableDispatcher($container);
        });

        $container->singleton('exception.handler', function () {
            return new Handler();
        });

        $container->instance('router', $router);
        Facade::setFacadeApplication($container);

        $routesFile = __DIR__ . '/../../routes/web.php';
        if (file_exists($routesFile)) {
            require $routesFile;
        } else {
            echo "Routes file not found: $routesFile\n";
        }

        self::$instance = [
            'router' => $router,
            'handler' => $container->make('exception.handler'),
        ];

        return self::$instance;
    }

    public static function isRouteRegistered(): bool
    {
        $kernel = self::bootstrap();
        $router = $kernel['router'];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $uri = trim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        $routes = $router->getRoutes();

        if ($routes->count() === 0) {
            return false;
        }

        foreach ($routes as $route) {
            if (in_array($method, $route->methods()) && $route->matches(
                Illuminate\Http\Request::create($uri, $method)
            )) {
                return true;
            }
        }

        return false;
    }
}

return Kernel::bootstrap();
