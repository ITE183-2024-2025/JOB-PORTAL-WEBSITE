<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Core\View;

$authController = new AuthController();

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $authController->login($email, $password);
        } else {
            $authController->showLogin();
        }
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'dashboard':
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /index.php?page=login");
            exit;
        }
        View::render('dashboard.html');
        break;

    default:
        $authController->showLogin();
        break;
}
