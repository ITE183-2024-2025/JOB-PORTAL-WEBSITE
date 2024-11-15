<?php

namespace App\Controllers;

use App\Repositories\JobRepository;

class JobController extends BaseController
{
    private $jobRepository;

    public function __construct(JobRepository $jobRepository = null)
    {
        $this->jobRepository = $jobRepository ?: new JobRepository();
    }

    public function index()
    {
        $jobs = $this->jobRepository->all();
        $this->jsonResponse(['data' => $jobs], 'success', 200);
    }

    public function store()
    {
        $data = $_POST;
        $created = $this->jobRepository->create($data);

        if ($created) {
            $this->jsonResponse(['message' => 'Job created successfully'], 'success', 201);
        } else {
            $this->jsonResponse(['message' => 'Failed to create job'], 'error', 400);
        }
    }

    public function show($id)
    {
        $job = $this->jobRepository->find($id);

        if ($job) {
            $this->jsonResponse(['data' => $job], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Job not found'], 'error', 404);
        }
    }

    public function update($id)
    {
        $data = $_POST;
        $updated = $this->jobRepository->update($id, $data);

        if ($updated) {
            $this->jsonResponse(['message' => 'Job updated successfully'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Failed to update job'], 'error', 400);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->jobRepository->delete($id);

        if ($deleted) {
            $this->jsonResponse(['message' => 'Job deleted successfully'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Failed to delete job'], 'error', 400);
        }
    }

    public function findByCreator($creatorId)
    {
        $jobs = $this->jobRepository->findByCreator($creatorId);

        if ($jobs) {
            $this->jsonResponse(['data' => $jobs], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'No jobs found for the given creator'], 'error', 404);
        }
    }

    public function findByCategory($categoryId)
    {
        $jobs = $this->jobRepository->findByCategory($categoryId);

        if ($jobs) {
            $this->jsonResponse(['data' => $jobs], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'No jobs found for the given category'], 'error', 404);
        }
    }
}
