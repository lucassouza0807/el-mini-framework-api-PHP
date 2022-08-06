<?php declare(strict_types=1);

namespace App\Providers;

use Error;

class middlewareProvider
{
    /*
      Aqui são registradas todas as middlewares
    */

    protected $middlewares = [
        /*
        "MiddlewareExample" => \App\Providers\MiddlewareExample::class,
        */
        "VerifyIfUserIsAuthenticated" => \App\Middlewares\VerifyIfUserIsAuthenticated::class,
    ];

    public function getMiddleware($middleware)
    {
        foreach ($this->middlewares as $middlewareName => $classMiddleware) {
            if ($middleware == $middlewareName) {
                return new $classMiddleware();

            } else {
                throw new Error("Middleware não encontrada");
            }
        }
    }
}
