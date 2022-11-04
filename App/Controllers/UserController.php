<?php

namespace App\Controllers;

use App\Controllers\Controller;

class UserController extends Controller
{
    public function teste()
    {
        echo $this->template->render("home.html.twig", ["nome" => "Pessoa Linda d+", "idade" => "40 anos"]);
    }
}
