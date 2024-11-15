<?php

namespace App\Repositories;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('users');
    }

    /**
     * Find a user by email.
     *
     * @param string $email
     * @return array|null
     */
    public function findByEmail($email)
    {
        return $this->findBy('email', $email);
    }

    /**
     * Authenticate a user by email and password.
     *
     * @param string $email
     * @param string $password
     * @return array|null
     */
    public function login($email, $password)
    {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }
}
