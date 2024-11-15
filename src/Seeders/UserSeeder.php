<?php

namespace App\Seeders;

use App\Core\Database;

class UserSeeder
{
    public function run()
    {
        $db = Database::connect();

        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT)
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT)
            ],
        ];

        foreach ($users as $user) {
            $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute($user);
        }
    }
}
