<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function get($route, $action)
    {
        $this->routes['GET'][$route] = $action;
    }

    public function post($route, $action)
    {
        $this->routes['POST'][$route] = $action;
    }

    public function dispatch($uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];

            [$controller, $method] = $action;
            $controllerInstance = new $controller();
            $controllerInstance->$method();
        } else {
            http_response_code(404);
            echo "Route not found!";
        }
    }
}
