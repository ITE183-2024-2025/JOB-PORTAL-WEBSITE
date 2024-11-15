<?php

namespace App\Controllers;

use App\Repositories\JobCategoryRepository;

class JobCategoryController extends BaseController
{
    private $jobCategoryRepository;

    public function __construct(JobCategoryRepository $jobCategoryRepository = null)
    {
        $this->jobCategoryRepository = $jobCategoryRepository ?: new JobCategoryRepository();
    }

    public function index()
    {
        $categories = $this->jobCategoryRepository->all();
        $this->jsonResponse(['data' => $categories], 'success', 200);
    }

    public function store()
    {
        $data = $_POST;
        $created = $this->jobCategoryRepository->create($data);

        if ($created) {
            $this->jsonResponse(['message' => 'Category created successfully'], 'success', 201);
        } else {
            $this->jsonResponse(['message' => 'Failed to create category'], 'error', 400);
        }
    }

    public function show($id)
    {
        $category = $this->jobCategoryRepository->find($id);

        if ($category) {
            $this->jsonResponse(['data' => $category], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Category not found'], 'error', 404);
        }
    }

    public function update($id)
    {
        $data = $_POST;
        $updated = $this->jobCategoryRepository->update($id, $data);

        if ($updated) {
            $this->jsonResponse(['message' => 'Category updated successfully'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Failed to update category'], 'error', 400);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->jobCategoryRepository->delete($id);

        if ($deleted) {
            $this->jsonResponse(['message' => 'Category deleted successfully'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Failed to delete category'], 'error', 400);
        }
    }
}
