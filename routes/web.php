<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \App\Providers\RouteServiceProvider;
use \App\Controllers\UserController;
use \App\Providers\middlewareProvider;
use \App\Helpers\View;

$app = new RouteServiceProvider(new MiddlewareProvider);

$app->get("/vagas", [UserController::class, "teste"]);

$app->get("/rastreio", function () {
    View::render("rastreio");
});

$app->get("/", function () {
    View::render("home");
});

$app->get("/pedidos", function () {
    $_SESSION['user_session'] = "lucas";
    echo $_SESSION['user_session'];
    //
}, ["middleware" => "VerifyIfUserIsAuthenticated"]);

$app->get("/pedidos-2", function () {
    echo "44";
});

$app->get("/user", [UserController::class, "teste"], ["middleware" => "VerifyIfUserIsAuthenticated"]);

$app->addNotFooundHandler(function () {
    View::render("404");
});


$app->run();
