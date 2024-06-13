<?php

namespace App\Helpers;

class View 
{
    public $template;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader("../views/");

        $this->template = new \Twig\Environment($loader);

    }
    public function render(string $view, array $data = [])
    {
        try {
            echo $this->template->render($view . ".html.twig", $data);

        } catch (\Exception $e) {
            echo $this->template->render("error-page.html.twig", [
                "message" => $e->getMessage()
            ]);
        }
    }
}
