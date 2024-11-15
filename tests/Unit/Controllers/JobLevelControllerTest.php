<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\JobLevelController;
use App\Repositories\JobLevelRepository;

class JobLevelControllerTest extends TestCase
{
    protected $jobLevelRepository;
    protected $controller;

    protected function setUp(): void
    {
        $this->jobLevelRepository = $this->createMock(JobLevelRepository::class);

        // Mock the JobLevelController with jsonResponse mocked
        $this->controller = $this->getMockBuilder(JobLevelController::class)
            ->setConstructorArgs([$this->jobLevelRepository])
            ->onlyMethods(['jsonResponse'])
            ->getMock();
    }

    public function testIndex()
    {
        $this->jobLevelRepository->method('all')->willReturn([]);

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
        $_POST = ['name' => 'Senior'];
        $this->jobLevelRepository->method('create')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Level created successfully']),
                $this->equalTo('success'),
                $this->equalTo(201)
            );

        $this->controller->store();
    }

    public function testStoreFailure()
    {
        $_POST = ['name' => 'Senior'];
        $this->jobLevelRepository->method('create')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to create level']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->store();
    }

    public function testShow()
    {
        $this->jobLevelRepository->method('find')->willReturn(['id' => 1, 'name' => 'Senior']);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['data' => ['id' => 1, 'name' => 'Senior']]),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->show(1);
    }

    public function testShowNotFound()
    {
        $this->jobLevelRepository->method('find')->willReturn(null);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Level not found']),
                $this->equalTo('error'),
                $this->equalTo(404)
            );

        $this->controller->show(999);
    }

    public function testUpdate()
    {
        $_POST = ['name' => 'Updated Level'];
        $this->jobLevelRepository->method('update')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Level updated successfully']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->update(1);
    }

    public function testUpdateFailure()
    {
        $_POST = ['name' => 'Updated Level'];
        $this->jobLevelRepository->method('update')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to update level']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->update(1);
    }

    public function testDestroy()
    {
        $this->jobLevelRepository->method('delete')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Level deleted successfully']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->destroy(1);
    }

    public function testDestroyFailure()
    {
        $this->jobLevelRepository->method('delete')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to delete level']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->destroy(1);
    }
}
