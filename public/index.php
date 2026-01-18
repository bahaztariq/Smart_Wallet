<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'Router.php';

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\IncomeController;
use App\Controllers\ExpenseController;

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

$router->add("/login", function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        (new AuthController())->login();
    } else {
        (new AuthController())->showLogin();
    }
});

$router->add("/register", function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        (new AuthController())->register();
    } else {
        (new AuthController())->showRegister();
    }
});

$router->add("/logout", function () {
    (new AuthController())->logout();
});

$router->add("/dashboard", function () {
    (new DashboardController())->index();
});

$router->add("/incomes", function () {
    (new IncomeController())->index();
});

$router->add("/incomes/add", function () {
    (new IncomeController())->store();
});

$router->add("/incomes/edit", function () {
    (new IncomeController())->update();
});

$router->add("/incomes/delete", function () {
    (new IncomeController())->delete();
});

$router->add("/expences", function () {
    (new ExpenseController())->index();
});

$router->add("/expences/add", function () {
    (new ExpenseController())->store();
});

$router->add("/expences/edit", function () {
    (new ExpenseController())->update();
});

$router->add("/expences/delete", function () {
    (new ExpenseController())->delete();
});

$router->dispatch($uri);
