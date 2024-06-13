<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \App\Providers\RouteServiceProvider;
use \App\Controllers\UserController;
use \App\Providers\middlewareProvider;
use \App\Helpers\View;
use \App\Providers\Request;
use \App\Providers\Response;


$app = new RouteServiceProvider(new MiddlewareProvider);
$view = new View();

$app->get("/", function() {
    echo "Teste";
}, ["middleware" => "auth"]);


$app->get("/teste", [UserController::class, "register"], ["middleware" => "auth"]);


$app->addNotFooundHandler(function () use ($view) {
    $view->render("404");
});

$app->run();
