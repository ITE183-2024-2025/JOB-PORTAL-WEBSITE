<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\JobController;
use App\Controllers\ApplicationController;

/**
 * Define routes for AJAX endpoints.
 *
 * @param Router $router
 */
function loadAjaxRoutes($router)
{
    $authMiddleware = function () {
        if (!App\Core\Session::get('user_id')) {
            header('Location: /login');
            exit;
        }
    };

    // Authentication
    $router->post('/login', [AuthController::class, 'login']);

    $router->group($authMiddleware, function ($router) {
        // User Management
        $router->get('/users', [UserController::class, 'index']);
        $router->post('/users', [UserController::class, 'store']);
        $router->get('/users/{id}', [UserController::class, 'show']);
        $router->put('/users/{id}', [UserController::class, 'update']);
        $router->delete('/users/{id}', [UserController::class, 'destroy']);
        $router->get('/users/find-by-email', [UserController::class, 'findByEmail']);

        // Job Management
        $router->get('/jobs', [JobController::class, 'index']);
        $router->post('/jobs', [JobController::class, 'store']);
        $router->get('/jobs/{id}', [JobController::class, 'show']);
        $router->put('/jobs/{id}', [JobController::class, 'update']);
        $router->delete('/jobs/{id}', [JobController::class, 'destroy']);
        $router->get('/jobs/find-by-creator/{creatorId}', [JobController::class, 'findByCreator']);
        $router->get('/jobs/find-by-category/{categoryId}', [JobController::class, 'findByCategory']);

        // Applications Management
        $router->get('/applications', [ApplicationController::class, 'index']);
        $router->post('/applications', [ApplicationController::class, 'store']);
        $router->get('/applications/{id}', [ApplicationController::class, 'show']);
        $router->put('/applications/{id}', [ApplicationController::class, 'update']);
        $router->delete('/applications/{id}', [ApplicationController::class, 'destroy']);
    });
}
