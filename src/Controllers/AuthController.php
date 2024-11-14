<?php

namespace App\Controllers;

use App\Core\Session;
use App\Repositories\UserRepository;

class AuthController extends BaseController
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function showLogin()
    {
        if (Session::get('user_id')) {
            $this->render('dashboard.html', ['title' => 'Dashboard']);
            return;
        }

        $this->render('login.html', ['title' => 'Login']);
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($email && $password) {
            $user = $this->userRepository->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                Session::set('user_id', $user['id']);
                if ($this->isAjaxRequest()) {
                    $this->jsonResponse(['redirect' => '/dashboard']);
                } else {
                    $this->render('dashboard.html', ['title' => 'Dashboard']);
                    return;
                }
            } else {
                $error = 'Invalid credentials';
            }
        } else {
            $error = 'Please provide both email and password';
        }

        if ($this->isAjaxRequest()) {
            $this->jsonResponse(['message' => $error], 'error', 400);
        } else {
            $this->render('login.html', ['title' => 'Login', 'error' => $error]);
        }
    }

    public function logout()
    {
        Session::destroy();
        $this->render('login.html', ['title' => 'Login', 'message' => 'You have successfully logged out']);
        return;
    }

    public function showDashboard()
    {
        if (!Session::get('user_id')) {
            $this->render('login.html', ['title' => 'Login', 'error' => 'You must be logged in to view this page']);
            return;
        }

        $this->render('dashboard.html', ['title' => 'Dashboard']);
    }
}
