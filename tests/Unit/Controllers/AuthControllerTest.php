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
        ob_start();
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->authController = new AuthController($this->userRepository);
        Session::start();
    }

    protected function tearDown(): void
    {
        ob_end_clean();
        Session::destroy();
    }

    /**
     * @runInSeparateProcess
     */
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

    /**
     * @runInSeparateProcess
     */
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

    /**
     * @runInSeparateProcess
     */
    public function testLoginSuccessRedirectsToDashboard()
    {
        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'password';

        $hashedPassword = password_hash('password', PASSWORD_DEFAULT);

        $this->userRepository->expects($this->once())
            ->method('findByEmail')
            ->with('test@example.com')
            ->willReturn(['id' => 1, 'password' => $hashedPassword]);

        $this->authController = $this->getMockBuilder(AuthController::class)
            ->setConstructorArgs([$this->userRepository])
            ->onlyMethods(['render', 'isAjaxRequest'])
            ->getMock();

        $this->authController->method('isAjaxRequest')
            ->willReturn(false);

        $this->authController->expects($this->once())
            ->method('render')
            ->with('dashboard.html', ['title' => 'Dashboard']);

        $this->authController->login();
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoginFailsWithInvalidCredentials()
    {
        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'wrongpassword';

        $this->userRepository->method('findByEmail')
            ->with('test@example.com')
            ->willReturn(['id' => 1, 'password' => password_hash('password', PASSWORD_DEFAULT)]);

        $this->authController = $this->getMockBuilder(AuthController::class)
            ->setConstructorArgs([$this->userRepository])
            ->onlyMethods(['render', 'isAjaxRequest'])
            ->getMock();

        $this->authController->method('isAjaxRequest')
            ->willReturn(false);
        
        $this->authController->expects($this->once())
            ->method('render')
            ->with('login.html', ['title' => 'Login', 'error' => 'Invalid credentials']);

        $this->authController->login();
    }

    /**
     * @runInSeparateProcess
     */
    public function testLogoutDestroysSessionAndRedirectsToLogin()
    {
        Session::set('user_id', 1);

        $this->authController = $this->getMockBuilder(AuthController::class)
            ->setConstructorArgs([$this->userRepository])
            ->onlyMethods(['render'])
            ->getMock();

        $this->authController->expects($this->once())
            ->method('render')
            ->with('login.html', ['title' => 'Login', 'message' => 'You have successfully logged out']);

        $this->authController->logout();

        $this->assertNull(Session::get('user_id'));
    }

    /**
     * @runInSeparateProcess
     */
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

    /**
     * @runInSeparateProcess
     */
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
