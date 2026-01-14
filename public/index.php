<?php

declare(strict_types=1);
require 'Router.php';


$uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

$route = new Router;
