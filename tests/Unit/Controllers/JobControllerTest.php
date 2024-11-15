<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\JobController;
use App\Repositories\JobRepository;

class JobControllerTest extends TestCase
{
    protected $jobRepository;
    protected $controller;

    protected function setUp(): void
    {
        $this->jobRepository = $this->createMock(JobRepository::class);

        // Mock the JobController with jsonResponse mocked
        $this->controller = $this->getMockBuilder(JobController::class)
            ->setConstructorArgs([$this->jobRepository])
            ->onlyMethods(['jsonResponse'])
            ->getMock();
    }

    public function testIndex()
    {
        $this->jobRepository->method('all')->willReturn([]);

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
        $_POST = ['title' => 'Software Engineer', 'category_id' => 1];
        $this->jobRepository->method('create')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Job created successfully']),
                $this->equalTo('success'),
                $this->equalTo(201)
            );

        $this->controller->store();
    }

    public function testStoreFailure()
    {
        $_POST = ['title' => 'Software Engineer', 'category_id' => 1];
        $this->jobRepository->method('create')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to create job']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->store();
    }

    public function testShow()
    {
        $this->jobRepository->method('find')->willReturn(['id' => 1, 'title' => 'Software Engineer']);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['data' => ['id' => 1, 'title' => 'Software Engineer']]),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->show(1);
    }

    public function testShowNotFound()
    {
        $this->jobRepository->method('find')->willReturn(null);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Job not found']),
                $this->equalTo('error'),
                $this->equalTo(404)
            );

        $this->controller->show(999);
    }

    public function testUpdate()
    {
        $_POST = ['title' => 'Updated Job', 'category_id' => 1];
        $this->jobRepository->method('update')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Job updated successfully']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->update(1);
    }

    public function testUpdateFailure()
    {
        $_POST = ['title' => 'Updated Job', 'category_id' => 1];
        $this->jobRepository->method('update')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to update job']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->update(1);
    }

    public function testDestroy()
    {
        $this->jobRepository->method('delete')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Job deleted successfully']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->destroy(1);
    }

    public function testDestroyFailure()
    {
        $this->jobRepository->method('delete')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to delete job']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->destroy(1);
    }
}
