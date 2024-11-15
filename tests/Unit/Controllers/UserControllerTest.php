<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\UserController;
use App\Repositories\UserRepository;

class UserControllerTest extends TestCase
{
    protected $userRepository;
    protected $controller;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);

        // Mock the UserController with jsonResponse mocked
        $this->controller = $this->getMockBuilder(UserController::class)
            ->setConstructorArgs([$this->userRepository])
            ->onlyMethods(['jsonResponse'])
            ->getMock();
    }

    public function testIndex()
    {
        $this->userRepository->method('all')->willReturn([]);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['data' => []]),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->index();
    }

    public function testStore()
    {
        $_POST = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $this->userRepository->method('create')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'User created successfully']),
                $this->equalTo('success'),
                $this->equalTo(201)
            );

        $this->controller->store();
    }

    public function testStoreFailure()
    {
        $_POST = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $this->userRepository->method('create')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to create user']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->store();
    }

    public function testShow()
    {
        $this->userRepository->method('find')->willReturn(['id' => 1, 'name' => 'John Doe']);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['data' => ['id' => 1, 'name' => 'John Doe']]),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->show(1);
    }

    public function testShowNotFound()
    {
        $this->userRepository->method('find')->willReturn(null);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'User not found']),
                $this->equalTo('error'),
                $this->equalTo(404)
            );

        $this->controller->show(999);
    }

    public function testUpdate()
    {
        $_POST = ['name' => 'John Smith'];
        $this->userRepository->method('update')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'User updated successfully']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->update(1);
    }

    public function testUpdateFailure()
    {
        $_POST = ['name' => 'John Smith'];
        $this->userRepository->method('update')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to update user']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->update(1);
    }

    public function testDestroy()
    {
        $this->userRepository->method('delete')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'User deleted successfully']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->destroy(1);
    }

    public function testDestroyFailure()
    {
        $this->userRepository->method('delete')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to delete user']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->destroy(1);
    }

    public function testFindByEmail()
    {
        $_GET['email'] = 'john@example.com';
        $this->userRepository->method('findByEmail')->willReturn(['id' => 1, 'email' => 'john@example.com']);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['data' => ['id' => 1, 'email' => 'john@example.com']]),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->findByEmail();
    }

    public function testFindByEmailNotFound()
    {
        $_GET['email'] = 'nonexistent@example.com';
        $this->userRepository->method('findByEmail')->willReturn(null);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'User not found']),
                $this->equalTo('error'),
                $this->equalTo(404)
            );

        $this->controller->findByEmail();
    }

    public function testFindByEmailWithoutParameter()
    {
        unset($_GET['email']);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Email parameter is required']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->findByEmail();
    }
}
