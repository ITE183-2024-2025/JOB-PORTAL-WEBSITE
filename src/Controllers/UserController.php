<?php

namespace App\Controllers;

use App\Repositories\UserRepository;

class UserController extends BaseController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository ?: new UserRepository();
    }

    public function index()
    {
        $users = $this->userRepository->all();
        $this->jsonResponse(['data' => $users], 'success', 200);
    }

    public function store()
    {
        $data = $_POST;
        $created = $this->userRepository->create($data);

        if ($created) {
            $this->jsonResponse(['message' => 'User created successfully'], 'success', 201);
        } else {
            $this->jsonResponse(['message' => 'Failed to create user'], 'error', 400);
        }
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if ($user) {
            $this->jsonResponse(['data' => $user], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'User not found'], 'error', 404);
        }
    }

    public function update($id)
    {
        $data = $_POST;
        $updated = $this->userRepository->update($id, $data);

        if ($updated) {
            $this->jsonResponse(['message' => 'User updated successfully'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Failed to update user'], 'error', 400);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->userRepository->delete($id);

        if ($deleted) {
            $this->jsonResponse(['message' => 'User deleted successfully'], 'success', 200);
        } else {
            $this->jsonResponse(['message' => 'Failed to delete user'], 'error', 400);
        }
    }

    public function findByEmail()
    {
        $email = $_GET['email'] ?? null;

        if ($email) {
            $user = $this->userRepository->findByEmail($email);
            if ($user) {
                $this->jsonResponse(['data' => $user], 'success', 200);
            } else {
                $this->jsonResponse(['message' => 'User not found'], 'error', 404);
            }
        } else {
            $this->jsonResponse(['message' => 'Email parameter is required'], 'error', 400);
        }
    }
}
