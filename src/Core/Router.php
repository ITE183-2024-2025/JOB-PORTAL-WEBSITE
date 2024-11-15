<?php

namespace App\Core;

class Router
{
    private $routes = [];
    private $currentMiddleware = null;

    public function group(callable $middleware, callable $routes)
    {
        $this->currentMiddleware = $middleware;
        $routes($this);
        $this->currentMiddleware = null;
    }

    public function get($route, $action)
    {
        $this->addRoute('GET', $route, $action);
    }

    public function post($route, $action)
    {
        $this->addRoute('POST', $route, $action);
    }

    public function put($route, $action)
    {
        $this->addRoute('PUT', $route, $action);
    }

    public function delete($route, $action)
    {
        $this->addRoute('DELETE', $route, $action);
    }

    private function addRoute($method, $route, $action)
    {
        $this->routes[$method][$route] = [
            'action' => $action,
            'middleware' => $this->currentMiddleware,
        ];
    }

    public function dispatch($uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        if (isset($this->routes[$method][$uri])) {
            $route = $this->routes[$method][$uri];
            $action = $route['action'];
            $middleware = $route['middleware'];

            if ($middleware && is_callable($middleware)) {
                call_user_func($middleware);
            }

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
