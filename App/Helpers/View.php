<?php

namespace App\Helpers;

use Error;

class View
{
    public static function render($view)
    {
        if (file_exists("./Views/" . $view . ".php")) {
            require_once("./Views/" . $view . ".php");
        } else {
            throw new Error("A view $view Não existe ");
        }
    }
}
