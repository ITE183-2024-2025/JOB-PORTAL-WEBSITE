<?php

namespace App\Controllers;

use App\Repositories\JobLevelRepository;

class JobLevelController extends BaseController
{
    private $jobLevelRepository;

    public function __construct(JobLevelRepository $jobLevelRepository = null)
    {
        $this->jobLevelRepository = $jobLevelRepository ?: new JobLevelRepository();
    }

    public function index()
    {
        $levels = $this->jobLevelRepository->all();
        $this->jsonResponse(['data' => $levels], 'success', 200);
    }

    public function store()
    {
        $data = $_POST;
        $created = $this->jobLevelRepository->create($data);

        if ($created) {
            $this->jsonResponse(['message' => 'Level created successfully'], 'success', 201);
        } else {
            $this->jsonResponse(['message' => 'Failed to create level'], 'error', 400);
        }
    }

    public function show($id)
    {
        $level = $this->jobLevelRepository->find($id);

        if ($level) {
            $this->jsonResponse(['data' => $level], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Level not found'], 'error', 404);
        }
    }

    public function update($id)
    {
        $data = $_POST;
        $updated = $this->jobLevelRepository->update($id, $data);

        if ($updated) {
            $this->jsonResponse(['message' => 'Level updated successfully'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Failed to update level'], 'error', 400);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->jobLevelRepository->delete($id);

        if ($deleted) {
            $this->jsonResponse(['message' => 'Level deleted successfully'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Failed to delete level'], 'error', 400);
        }
    }
}
