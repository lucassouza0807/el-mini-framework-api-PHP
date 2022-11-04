<?php 

namespace App\Controllers;

abstract class Controller {
    public $template;

    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader('../views');
        
        $this->template = $twig = new \Twig\Environment($loader);
       
    }

}