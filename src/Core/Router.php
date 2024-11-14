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
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];

            if (is_callable($action)) {
                return call_user_func($action);
            } elseif (is_array($action) && count($action) === 2) {
                [$controller, $method] = $action;
                $controllerInstance = new $controller();
                return $controllerInstance->$method();
            } else {
                return $this->handleNotFound();
            }
        } else {
            return $this->handleNotFound();
        }
    }

    private function handleNotFound()
    {
        http_response_code(404);
        return "404 Not Found";
    }
}
