<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Core\Router;
use App\Core\Session;

Session::start();

$router = new Router();

$authMiddleware = function () {
    if (!Session::get('user')) {
        header('Location: /login');
        exit;
    }
};

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->group($authMiddleware, function ($router) {
    $router->get('/', [AuthController::class, 'showDashboard']);
    $router->get('/dashboard', [AuthController::class, 'showDashboard']);
});

$router->dispatch($_SERVER['REQUEST_URI']);
