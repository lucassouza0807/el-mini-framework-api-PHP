<?php

namespace App\Controllers;

use App\Controllers\Controller;

class UserController extends Controller
{
    public function register()
    {
        echo "My eggs";
    }
    public function teste()
    {
        echo $this->template->render("home.html.twig", ["nome" => "Pessoa Linda d+", "idade" => "40 anos"]);
    }

    public function fix($id)
    {
        echo "O id é $id";
    }
}
