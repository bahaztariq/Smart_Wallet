<?php

declare(strict_types=1);



require_once 'Router.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
    $uri = substr($uri, strlen($scriptName));
}
if ($uri === false || $uri === '') {
    $uri = '/';
}


$router = new Router;

$viewsPath = __DIR__ . '/../App/views';

$router->add("/", function () use ($viewsPath) {
    require $viewsPath . '/home/index.php';
});

$router->add("/login", function () use ($viewsPath) {
    require $viewsPath . '/auth/login.php';
});

$router->add("/register", function () use ($viewsPath) {
    require $viewsPath . '/auth/Register.php';
});

$router->add("/dashboard", function () use ($viewsPath) {
    require $viewsPath . '/Dashboard/dashboard.php';
});

$router->add("/incomes", function () use ($viewsPath) {
    require $viewsPath . '/incomes/incomes.php';
});

$router->add("/incomes/add", function () use ($viewsPath) {
    require $viewsPath . '/incomes/add.php';
});

$router->add("/incomes/edit", function () use ($viewsPath) {
    require $viewsPath . '/incomes/edit.php';
});

$router->add("/incomes/delete", function () use ($viewsPath) {
    require $viewsPath . '/incomes/delete.php';
});

$router->add("/expences", function () use ($viewsPath) {
    require $viewsPath . '/expences/expences.php';
});

$router->add("/expences/add", function () use ($viewsPath) {
    require $viewsPath . '/expences/add.php';
});

$router->add("/expences/edit", function () use ($viewsPath) {
    require $viewsPath . '/expences/edit.php';
});

$router->add("/expences/delete", function () use ($viewsPath) {
    require $viewsPath . '/expences/delete.php';
});

$router->add("/logout", function () use ($viewsPath) {
    require $viewsPath . '/auth/logout.php';
});


$router->dispatch($uri);
