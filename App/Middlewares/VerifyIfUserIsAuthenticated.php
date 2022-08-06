<?php

namespace App\Middlewares;

use Closure;

class VerifyIfUserIsAuthenticated
{

    public function handle($next) 
    {
        //echo $next;
        $logged = true;

        if ($logged == false) {
            header("Location: http://localhost:8001/");
            die();
        }

        call_user_func($next);
    }
}
