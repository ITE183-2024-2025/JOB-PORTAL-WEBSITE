<?php

namespace App\Repositories;
use PDO;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('users'); // Specify the table name for the users table
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
