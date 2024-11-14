<?php

namespace App\Migrations;

use App\Core\Database;

class CreateUsersTable
{
    public function up()
    {
        $db = Database::connect();
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $db->exec($sql);
    }

    public function down()
    {
        $db = Database::connect();
        $sql = "DROP TABLE IF EXISTS users";
        $db->exec($sql);
    }
}
