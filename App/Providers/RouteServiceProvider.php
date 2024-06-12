<?php

declare(strict_types=1);

namespace App\Providers;

use Closure;

use App\Interfaces\MiddlewareProviderInterface;

class RouteServiceProvider
{
    private $path;
    private $handlers;
    private $middleware;
    private $notFoundHandler = [];
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

    function addHandler(string $method, string $path, closure|array $handler = null, closure $middleware = null)
    {
        $this->handlers[$method . $path] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }

    public function get(string $path, closure|array $handler, closure $middleware = null)
    {
        $this->path = $path;

        $this->addHandler(self::GET, $path, $handler, $middleware);
    }

    public function post(string $path, closure|array $handler, closure $middleware = null)
    {
        $this->path = $path;

        $this->addHandler(self::POST, $path, $handler, $middleware);
    }

    public function delete(string $path, closure|array $handler, closure $middleware = null)
    {
        $this->path = $path;

        $this->addHandler(self::DELETE, $path, $handler, $middleware);

    }

    public function put(string $path, closure|array $handler, closure $middleware = null)
    {
        $this->path = $path;

        $this->addHandler(self::PUT, $path, $handler, $middleware);

    }

    public function addNotFooundHandler(closure $handler): void
    {
        $this->notFoundHandler = $handler;
    }

    public function middleware(closure $middleware)
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

                // Correct the regular expression
                $pattern = preg_replace('/\:([^\/]+)/', '(?P<$1>[^/]+)', $handler['path']);
                $pattern = '#^' . $pattern . '$#';

                if (preg_match($pattern, $url['path'], $matches)) {

                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY); // Only keep named subpattern matches

                    if (is_array($handler['handler'])) {
                        $class = new $handler['handler'][0];
                        $method = $handler['handler'][1];
                        $callback = [$class, $method];
                    }

                    if (is_callable($handler['handler'])) {
                        $callback = $handler["handler"];
                    }
                    
                    call_user_func_array($callback, $params);

                    return;

                }

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
                    echo $handler['path'];

                    $pattern = preg_replace('/\:([^\/]+)/', '(?P<$1>[^/]+)', $handler['path']);
                    $pattern = '#^' . $pattern . '$#';

                    print_r($pattern);

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

            call_user_func_array($callback, $params);

        } catch (\Exception $e) {
            echo "Minhas Bolas";
        }

    }

}
