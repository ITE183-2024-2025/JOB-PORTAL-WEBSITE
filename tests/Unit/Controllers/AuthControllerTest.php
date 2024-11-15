<?php

namespace Tests\Unit\Controllers;

use App\Controllers\AuthController;
use App\Core\Session;
use App\Repositories\UserRepository;
use PHPUnit\Framework\TestCase;

class AuthControllerTest extends TestCase
{
    protected $authController;
    protected $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);

        // Mock the AuthController with jsonResponse mocked
        $this->authController = $this->getMockBuilder(AuthController::class)
            ->setConstructorArgs([$this->userRepository])
            ->onlyMethods(['jsonResponse', 'isAjaxRequest'])
            ->getMock();

        Session::start();
    }

    protected function tearDown(): void
    {
        Session::destroy();
    }
    public function testLoginSuccessful()
    {
        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'password';
    
        $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
        $this->userRepository->method('findByEmail')
            ->with('test@example.com')
            ->willReturn(['id' => 1, 'password' => $hashedPassword]);
    
        $this->authController = $this->getMockBuilder(AuthController::class)
            ->setConstructorArgs([$this->userRepository])
            ->onlyMethods(['isAjaxRequest', 'jsonResponse'])
            ->getMock();
    
        $this->authController->method('isAjaxRequest')
            ->willReturn(true);
    
        $this->authController->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Login successful', 'redirect' => '/dashboard']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );
    
        $this->authController->login();
    }
    
    

    public function testLoginFailsWithInvalidCredentials()
    {
        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'wrongpassword';

        $this->userRepository->method('findByEmail')
            ->with('test@example.com')
            ->willReturn(['id' => 1, 'password' => password_hash('password', PASSWORD_DEFAULT)]);

        $this->authController->method('isAjaxRequest')
            ->willReturn(true);

        $this->authController->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Invalid credentials']),
                $this->equalTo('error'),
                $this->equalTo(401)
            );

        $this->authController->login();
    }

    public function testLoginFailsWithMissingFields()
    {
        $_POST = []; // Missing email and password

        $this->authController->method('isAjaxRequest')
            ->willReturn(true);

        $this->authController->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Email and password are required']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->authController->login();
    }

    public function testLogout()
    {
        Session::set('user_id', 1);
    
        $this->authController->method('isAjaxRequest')
            ->willReturn(true);
    
        $this->authController->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'You have successfully logged out', 'redirect' => '/login']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );
    
        $this->authController->logout();

    }
    

    public function testShowLoginRendersDashboardIfAuthenticated()
    {
        Session::set('user_id', 1);

        $this->authController = $this->getMockBuilder(AuthController::class)
            ->setConstructorArgs([$this->userRepository])
            ->onlyMethods(['render'])
            ->getMock();

        $this->authController->expects($this->once())
            ->method('render')
            ->with('dashboard.html', ['title' => 'Dashboard']);

        $this->authController->showLogin();
    }

    public function testShowLoginRendersLoginIfNotAuthenticated()
    {
        Session::set('user_id', null);

        $this->authController = $this->getMockBuilder(AuthController::class)
            ->setConstructorArgs([$this->userRepository])
            ->onlyMethods(['render'])
            ->getMock();

        $this->authController->expects($this->once())
            ->method('render')
            ->with('login.html', ['title' => 'Login']);

        $this->authController->showLogin();
    }

    public function testShowDashboardRendersDashboardIfAuthenticated()
    {
        Session::set('user_id', 1);

        $this->authController = $this->getMockBuilder(AuthController::class)
            ->setConstructorArgs([$this->userRepository])
            ->onlyMethods(['render'])
            ->getMock();

        $this->authController->expects($this->once())
            ->method('render')
            ->with('dashboard.html', ['title' => 'Dashboard']);

        $this->authController->showDashboard();
    }

    public function testShowDashboardRedirectsToLoginIfNotAuthenticated()
    {
        Session::set('user_id', null);

        $this->authController = $this->getMockBuilder(AuthController::class)
            ->setConstructorArgs([$this->userRepository])
            ->onlyMethods(['render'])
            ->getMock();

        $this->authController->expects($this->once())
            ->method('render')
            ->with('login.html', ['title' => 'Login', 'error' => 'You must be logged in to view this page']);

        $this->authController->showDashboard();
    }
}
