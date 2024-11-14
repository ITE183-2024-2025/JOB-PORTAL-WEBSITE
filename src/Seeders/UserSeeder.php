<?php

namespace App\Seeders;

use App\Core\Database;

class UserSeeder
{
    public function run()
    {
        $db = Database::connect();

        $sql = "INSERT INTO users (name, email, password) VALUES
                ('John Doe', 'john@example.com', :password),
                ('Jane Doe', 'jane@example.com', :password)";

        $stmt = $db->prepare($sql);
        $stmt->execute([':password' => password_hash('password123', PASSWORD_BCRYPT)]);
    }
}
