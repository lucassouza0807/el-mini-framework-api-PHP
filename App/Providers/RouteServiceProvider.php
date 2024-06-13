<?php

declare(strict_types=1);

namespace App\Providers;

use Closure;

use App\Interfaces\MiddlewareProviderInterface;
use App\Helpers\View;

class RouteServiceProvider extends View
{
    private $path;
    private $handlers;
    private $middleware;
    private $notFoundHandler = [];
    private $notFoundParameters = [];
    //methods
    private const POST = 'POST';
    private const GET = 'GET';
    private const DELETE = "DELETE";
    private const PATCH = "PATCH";
    private const PUT = "PUT";

    public function __construct(MiddlewareProviderInterface $middleware)
    {

        $this->middleware = $middleware;
    }

    function addHandler(string $method, string $path, closure|array $handler = null, $middleware = null)
    {
        $this->handlers[$method . $path] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }

    public function get(string $path, closure|array $handler, $middleware = null)
    {
        $this->path = $path;

        $this->addHandler(self::GET, $path, $handler, $middleware);
    }

    public function post(string $path, closure|array $handler, $middleware = null)
    {
        $this->path = $path;

        $this->addHandler(self::POST, $path, $handler, $middleware);
    }

    public function delete(string $path, closure|array $handler, $middleware = null)
    {
        $this->path = $path;

        $this->addHandler(self::DELETE, $path, $handler, $middleware);

    }

    public function put(string $path, closure|array $handler, $middleware = null)
    {
        $this->path = $path;

        $this->addHandler(self::PUT, $path, $handler, $middleware);

    }

    public function addNotFooundHandler(closure $handler): void
    {
        $reflection = new \ReflectionFunction($handler);
        $parameters = $reflection->getParameters();

        $this->notFoundParameters = $parameters;

        $this->notFoundHandler = $handler;
    }

    public function handleMiddleware(closure $middleware)
    {
        $this->middleware = $middleware;
    }

    public function run()
    {
        try {
            $url = parse_url($_SERVER['REQUEST_URI']);
            $callback = "";
            $class = null;
            $method = null;
            $params = [];

            foreach ($this->handlers as $handler) {
                $pattern = preg_replace('/\:([^\/]+)/', '(?P<$1>[^/]+)', $handler['path']);
                $pattern = '#^' . $pattern . '$#';

                /**
                 * Case has some middleware
                 */


                if (preg_match($pattern, $url['path'], $matches) && $handler["middleware"]) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    $middleware = $this->middleware->getMiddleware($handler['middleware']['middleware']);

                    $middlewareClass = new $middleware();

                    if (is_array($handler['handler'])) {
                        $class = new $handler['handler'][0];
                        $method = $handler['handler'][1];
                        $callback = [$class, $method];
                    }

                    if (is_callable($handler['handler'])) {
                        $callback = $handler["handler"];
                    }

                    call_user_func_array([$middlewareClass, "handle"], [$handler['handler'], $params]);

                    return;

                }


                if (preg_match($pattern, $url['path'], $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    if (is_array($handler['handler'])) {
                        $class = new $handler['handler'][0];
                        $method = $handler['handler'][1];
                        $callback = [$class, $method];
                    }

                    if (is_callable($handler['handler'])) {
                        $callback = $handler["handler"];
                    }

                    call_user_func_array($callback, [$params]);

                    return;

                }

            }

            if (!$callback) {
                header("HTTP/1.0 404 Not Found");
               
                call_user_func($this->notFoundHandler);

                die();
            }


        } catch (\Exception $e) {

        }

    }

}
