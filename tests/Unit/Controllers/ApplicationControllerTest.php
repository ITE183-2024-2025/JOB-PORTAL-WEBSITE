<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\ApplicationController;
use App\Repositories\ApplicationRepository;

class ApplicationControllerTest extends TestCase
{
    protected $applicationRepository;
    protected $controller;

    protected function setUp(): void
    {
        $this->applicationRepository = $this->createMock(ApplicationRepository::class);

        // Mock the ApplicationController with jsonResponse mocked
        $this->controller = $this->getMockBuilder(ApplicationController::class)
            ->setConstructorArgs([$this->applicationRepository])
            ->onlyMethods(['jsonResponse'])
            ->getMock();
    }

    public function testIndex()
    {
        $this->applicationRepository->method('all')->willReturn([]);

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
        $_POST = ['user_id' => 1, 'job_id' => 2];
        $this->applicationRepository->method('create')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Application submitted successfully']),
                $this->equalTo('success'),
                $this->equalTo(201)
            );

        $this->controller->store();
    }

    public function testStoreFailure()
    {
        $_POST = ['user_id' => 1, 'job_id' => 2];
        $this->applicationRepository->method('create')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to submit application']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->store();
    }

    public function testShow()
    {
        $this->applicationRepository->method('find')->willReturn(['id' => 1, 'user_id' => 1, 'job_id' => 2]);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['data' => ['id' => 1, 'user_id' => 1, 'job_id' => 2]]),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->show(1);
    }

    public function testShowNotFound()
    {
        $this->applicationRepository->method('find')->willReturn(null);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Application not found']),
                $this->equalTo('error'),
                $this->equalTo(404)
            );

        $this->controller->show(999);
    }

    public function testUpdate()
    {
        $_POST = ['user_id' => 1, 'job_id' => 2];
        $this->applicationRepository->method('update')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Application updated successfully']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->update(1);
    }

    public function testUpdateFailure()
    {
        $_POST = ['user_id' => 1, 'job_id' => 2];
        $this->applicationRepository->method('update')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to update application']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->update(1);
    }

    public function testDestroy()
    {
        $this->applicationRepository->method('delete')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Application deleted successfully']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->destroy(1);
    }

    public function testDestroyFailure()
    {
        $this->applicationRepository->method('delete')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to delete application']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->destroy(1);
    }
}
