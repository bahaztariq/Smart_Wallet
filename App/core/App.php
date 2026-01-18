<?php

namespace App\Core;

class App
{
    protected string $controller = 'HomeController';
    protected string $method = 'index';
    protected array $params = [];

    private array $routes = [];

    public function __construct()
    {
        session_start();
    }

    public function addRoute(string $pattern, string $controller, string $method = 'index'): void
    {
        $this->routes[$pattern] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function parseUrl(): array
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            $scriptName = dirname($_SERVER['SCRIPT_NAME']);
            if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
                $uri = substr($uri, strlen($scriptName));
            }

            return explode('/', filter_var(trim($uri, '/'), FILTER_SANITIZE_URL));
        }

        return [];
    }

    public function run(): void
    {
        $url = $this->parseUrl();

        $uri = '/' . implode('/', $url);
        if ($uri === '/') {
            $uri = '/';
        }

        foreach ($this->routes as $pattern => $route) {
            if ($this->matchRoute($pattern, $uri)) {
                $this->dispatchRoute($route);
                return;
            }
        }

        $this->dispatchAutomatic($url);
    }

    private function matchRoute(string $pattern, string $uri): bool
    {
        return $pattern === $uri;
    }

    private function dispatchRoute(array $route): void
    {
        $controllerName = 'App\\Controllers\\' . $route['controller'];

        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            $method = $route['method'];

            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $this->params);
                return;
            }
        }

        $this->notFound();
    }

    private function dispatchAutomatic(array $url): void
    {
        if (!empty($url[0])) {
            $controllerName = 'App\\Controllers\\' . ucfirst($url[0]) . 'Controller';

            if (class_exists($controllerName)) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        $controllerClass = $this->controller;
        if (strpos($controllerClass, '\\') === false) {
            $controllerClass = 'App\\Controllers\\' . $controllerClass;
        }

        if (!class_exists($controllerClass)) {
            $this->notFound();
            return;
        }

        $controller = new $controllerClass();

        if (isset($url[1])) {
            if (method_exists($controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        if (method_exists($controller, $this->method)) {
            call_user_func_array([$controller, $this->method], $this->params);
        } else {
            $this->notFound();
        }
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        exit;
    }

    public function getBaseUrl(): string
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);

        return $protocol . '://' . $host . ($scriptName !== '/' ? $scriptName : '');
    }
}
