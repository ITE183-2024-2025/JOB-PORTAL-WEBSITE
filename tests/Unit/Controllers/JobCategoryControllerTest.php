<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\JobCategoryController;
use App\Repositories\JobCategoryRepository;

class JobCategoryControllerTest extends TestCase
{
    protected $jobCategoryRepository;
    protected $controller;

    protected function setUp(): void
    {
        $this->jobCategoryRepository = $this->createMock(JobCategoryRepository::class);

        // Mock the JobCategoryController with jsonResponse mocked
        $this->controller = $this->getMockBuilder(JobCategoryController::class)
            ->setConstructorArgs([$this->jobCategoryRepository])
            ->onlyMethods(['jsonResponse'])
            ->getMock();
    }

    public function testIndex()
    {
        $this->jobCategoryRepository->method('all')->willReturn([]);

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
        $_POST = ['name' => 'Engineering'];
        $this->jobCategoryRepository->method('create')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Category created successfully']),
                $this->equalTo('success'),
                $this->equalTo(201)
            );

        $this->controller->store();
    }

    public function testStoreFailure()
    {
        $_POST = ['name' => 'Engineering'];
        $this->jobCategoryRepository->method('create')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to create category']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->store();
    }

    public function testShow()
    {
        $this->jobCategoryRepository->method('find')->willReturn(['id' => 1, 'name' => 'Engineering']);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['data' => ['id' => 1, 'name' => 'Engineering']]),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->show(1);
    }

    public function testShowNotFound()
    {
        $this->jobCategoryRepository->method('find')->willReturn(null);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Category not found']),
                $this->equalTo('error'),
                $this->equalTo(404)
            );

        $this->controller->show(999);
    }

    public function testUpdate()
    {
        $_POST = ['name' => 'Updated Category'];
        $this->jobCategoryRepository->method('update')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Category updated successfully']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->update(1);
    }

    public function testUpdateFailure()
    {
        $_POST = ['name' => 'Updated Category'];
        $this->jobCategoryRepository->method('update')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to update category']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->update(1);
    }

    public function testDestroy()
    {
        $this->jobCategoryRepository->method('delete')->willReturn(true);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Category deleted successfully']),
                $this->equalTo('success'),
                $this->equalTo(200)
            );

        $this->controller->destroy(1);
    }

    public function testDestroyFailure()
    {
        $this->jobCategoryRepository->method('delete')->willReturn(false);

        $this->controller->expects($this->once())
            ->method('jsonResponse')
            ->with(
                $this->equalTo(['message' => 'Failed to delete category']),
                $this->equalTo('error'),
                $this->equalTo(400)
            );

        $this->controller->destroy(1);
    }
}
