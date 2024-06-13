<?php

namespace App\Middlewares;

use Closure;
use App\Providers\Response;
use App\Providers\Request;

class VerifyIfUserIsAuthenticated
{

    public function handle(Closure|array $next, array $params = null)
    {
        //echo $next;
        $callback = [];

        $logged = true;

        if ($logged == false) {

            return Response::json([
                "message" => "Não autorizado"
            ], 401);
            //die();
        }

        Request::next($next);

    }
}
