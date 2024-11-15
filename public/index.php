<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Session;

Session::start();

require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../routes/view.php';
require_once __DIR__ . '/../routes/ajax.php';

try {
    initializeDatabaseIfRequired();
} catch (Exception $e) {
    die("Failed to initialize the database: " . $e->getMessage());
}

$router = new Router();

loadViewRoutes($router);
loadAjaxRoutes($router);

$router->dispatch($_SERVER['REQUEST_URI']);
