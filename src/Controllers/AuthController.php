<?php

namespace App\Controllers;

use App\Core\Session;
use App\Repositories\UserRepository;

class AuthController extends BaseController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository ?: new UserRepository();
    }

    /**
     * Render the login page.
     */
    public function showLogin()
    {
        if (Session::get('user_id')) {
            $this->render('dashboard.html', ['title' => 'Dashboard']);
            return;
        }

        $this->render('login.html', ['title' => 'Login']);
    }

    /**
     * Handle user login via AJAX.
     */
    public function login()
    {
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->jsonResponse(['message' => 'Email and password are required'], 'error', 400);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->jsonResponse(['message' => 'Invalid email format'], 'error', 400);
            return;
        }

        $user = $this->userRepository->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            Session::set('user_id', $user['id']);
            $this->jsonResponse(['message' => 'Login successful', 'redirect' => '/dashboard'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Invalid credentials'], 'error', 401);
        }
    }



    /**
     * Handle user logout via AJAX.
     */
    public function logout()
    {
        Session::destroy();
        $this->jsonResponse(['message' => 'You have successfully logged out', 'redirect' => '/login'], 'success', 200);
    }

    /**
     * Render the dashboard page.
     */
    public function showDashboard()
    {
        if (!Session::get('user_id')) {
            $this->render('login.html', ['title' => 'Login', 'error' => 'You must be logged in to view this page']);
            return;
        }

        $this->render('dashboard.html', ['title' => 'Dashboard']);
    }
}
