<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Core\View;

class AuthController
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function showLogin()
    {
        View::render('login.html', ['title' => 'Login']);
    }

    public function showDashboard()
    {
        View::render('dashboard.html', ['title' => 'Dashboard']);
    }

    public function login($email, $password)
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header("Location: /index.php?page=dashboard");
            exit;
        } else {
            View::render('login.html', ['error' => 'Invalid email or password']);
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /index.php?page=login");
        exit;
    }
}
