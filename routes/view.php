<?php

use App\Controllers\AuthController;
use App\Core\Session;

/**
 * Define routes for pages/views.
 *
 * @param Router $router
 */
function loadViewRoutes($router)
{
    $authMiddleware = function () {
        if (!Session::get('user_id')) {
            header('Location: /login');
            exit;
        }
    };

    $router->get('/login', [AuthController::class, 'showLogin']);

    $router->group($authMiddleware, function ($router) {
        $router->get('/dashboard', [AuthController::class, 'showDashboard']);
        $router->get('/logout', [AuthController::class, 'logout']);
    });
}
