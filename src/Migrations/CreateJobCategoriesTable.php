<?php

namespace App\Migrations;

use App\Core\Database;

class CreateJobCategoriesTable
{
    public function up()
    {
        $db = Database::connect();
        $sql = "CREATE TABLE IF NOT EXISTS job_categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            other_details TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $db->exec($sql);
    }

    public function down()
    {
        $db = Database::connect();
        $sql = "DROP TABLE IF EXISTS job_categories";
        $db->exec($sql);
    }
}
