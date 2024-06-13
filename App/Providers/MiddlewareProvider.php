<?php declare(strict_types=1);

namespace App\Providers;

use Error;
use App\Interfaces\MiddlewareProviderInterface;

class middlewareProvider implements MiddlewareProviderInterface
{
    /*
      Aqui são registradas todas as middlewares
    */

    protected $middlewares = [
        /*
        "MiddlewareExample" => \App\Providers\MiddlewareExample::class,
        */
        "auth" => \App\Middlewares\VerifyIfUserIsAuthenticated::class,
        // "BearerToken" => 
    ];

    public function getMiddleware($middleware)
    {

        try {
            foreach ($this->middlewares as $middlewareName => $classMiddleware) {
                if ($middleware == $middlewareName) {
                    return new $classMiddleware();

                } else {
                    throw new Error("Middleware não encontrada");
                }
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
