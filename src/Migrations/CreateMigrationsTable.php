<?php

namespace App\Migrations;

use App\Core\Database;

class CreateMigrationsTable
{
    public function up()
    {
        $db = Database::connect();
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            batch INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $db->exec($sql);
    }

    public function down()
    {
        $db = Database::connect();
        $sql = "DROP TABLE IF EXISTS migrations";

        $db->exec($sql);
    }
}
