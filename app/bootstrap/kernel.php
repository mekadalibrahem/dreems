<?php

require __DIR__ . '/../../vendor/autoload.php';

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
    public static function bootstrap()
    {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Set up the container
        $container = new Container;

        // Set up database connection (Eloquent)
        $capsule = new Capsule;
        $capsule->addConnection(require __DIR__ . '/../../config/database.php');
        $capsule->setEventDispatcher(new Dispatcher($container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // Set up event dispatcher
        $events = new Dispatcher($container);

        // Set up the router
        $router = new Router($events, $container);

        // Bind the CallableDispatcher to the container
        $container->singleton(CallableDispatcherContract::class, function ($container) {
            return new CallableDispatcher($container);
        });

        // Bind the exception handler to the container
        $container->singleton('exception.handler', function () {
            return new Handler();
        });

        // Bind the router to the container
        $container->instance('router', $router);

        // Set the container as the facade root
        Facade::setFacadeApplication($container);

        // Load routes
        require __DIR__ . '/../../routes/web.php';

        return [
            'router' => $router,
            'handler' => $container->make('exception.handler'),
        ];
    }
}

return Kernel::bootstrap();