<?php

namespace App\Helpers;

use Error;

class View
{
    public static function render($view)
    {
        if (file_exists("../Views/" . $view . ".html.twig")) {
            require_once("../Views/" . $view . ".html.twig");
        } else {
            throw new Error("A view $view Não existe ");
        }
    }
}
