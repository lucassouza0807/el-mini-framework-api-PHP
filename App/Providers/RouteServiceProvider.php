<?php

declare(strict_types=1);

namespace App\Providers;

use App\Providers\MiddlewareProvider;

class RouteServiceProvider
{
    private $handlers;
    private $middleware;
    private $notFoundHandler = [];
    //methods
    private const POST = 'POST';
    private const GET = 'GET';
    private const DELETE = "DELETE";
    private const PATCH = "PATCH";

    public function __construct(MiddlewareProvider $middleware)
    {
        $this->middleware = $middleware;
    }

    function addHandler(string $method, string $path, $handler, $middleware)
    {
        $this->handlers[$method . $path] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }

    public function get($path, $handler, $middleware = null)
    {
        $this->addHandler(self::GET, $path, $handler, $middleware);
    }

    public function post($path, $handler, $middleware = null)
    {
        $this->addHandler(self::POST, $path, $middleware = null, $handler);
    }

    public function addNotFooundHandler($handler): void
    {
        $this->notFoundHandler = $handler;
    }

    public function middleware($middleware)
    {
        $this->middleware = $middleware;
    }

    public function run()
    {
        $url = parse_url($_SERVER['REQUEST_URI']);
        $callback = "";
        $class = null;
        $method = null;


        foreach ($this->handlers as $handler) {
            if ($url['path'] === $handler['path'] && $handler['method'] === $_SERVER['REQUEST_METHOD'] && isset($handler['middleware'])) {
                $middleware = $this->middleware->getMiddleware($handler['middleware']["middleware"]);

                if (is_callable($handler['handler'])) {
                    $middleware->handle($handler['handler']);
                }

                if (is_array($handler['handler'])) {
                    $class = new $handler["handler"][0];
                    $method = $handler["handler"][1];

                    $middleware->handle([$class, $method]);
                }

                die();
            }

            if ($url['path'] === $handler['path'] && $handler['method'] === $_SERVER['REQUEST_METHOD']) {
                if (is_callable($handler['handler'])) {
                    $callback = $handler['handler'];
                }

                if (is_array($handler['handler'])) {
                    $class = new $handler['handler'][0];
                    $method = $handler['handler'][1];

                    $callback = [$class, $method];
                }
            }
        }
        if (!$callback) {
            header("HTTP/1.0 404 Not Found");
            call_user_func($this->notFoundHandler);
            die();
        }

        call_user_func($callback);
    }
}
