<?php

namespace App\Controllers;

use App\Repositories\ApplicationRepository;

class ApplicationController extends BaseController
{
    private $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository = null, $testing = false)
    {
        parent::__construct($testing);
        $this->applicationRepository = $applicationRepository ?: new ApplicationRepository();
    }

    public function index()
    {
        $applications = $this->applicationRepository->all();
        $this->jsonResponse(['data' => $applications], 'success', 200);
    }

    public function store()
    {
        $data = $_POST;
        $created = $this->applicationRepository->create($data);

        if ($created) {
            $this->jsonResponse(['message' => 'Application submitted successfully'], 'success', 201);
        } else {
            $this->jsonResponse(['message' => 'Failed to submit application'], 'error', 400);
        }
    }

    public function show($id)
    {
        $application = $this->applicationRepository->find($id);

        if ($application) {
            $this->jsonResponse(['data' => $application], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Application not found'], 'error', 404);
        }
    }

    public function update($id)
    {
        $data = $_POST;
        $updated = $this->applicationRepository->update($id, $data);

        if ($updated) {
            $this->jsonResponse(['message' => 'Application updated successfully'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Failed to update application'], 'error', 400);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->applicationRepository->delete($id);

        if ($deleted) {
            $this->jsonResponse(['message' => 'Application deleted successfully'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Failed to delete application'], 'error', 400);
        }
    }
}
