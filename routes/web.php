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

$app->get("/", function () use ($view) {
    $view->render("home");
});

$app->post("/api/user", function () use ($view) {
    Response::json(["message" => "Not found"], 404);
});

$app->post("/user/:id", [UserController::class, "fix"]);

$app->post("/teste/:teste", function($teste) {
    Response::json([
        "field" => $teste,
        "query_string" => Request::get("teste"),
        "pessoa" => Request::get("pessoa")
    ]);
});

$app->get("/cadastro", function() use($view) {
    $view->render("cadastro");
});


$app->post("/cadastrex", function () use($view) {
    $view->render("teste", [
        "input" => Request::post("nome")
    ]);
});

$app->addNotFooundHandler(function () use ($view) {
    $view->render("404", [
        "erro" => "Erro fatal"
    ]);
});


$app->run();
