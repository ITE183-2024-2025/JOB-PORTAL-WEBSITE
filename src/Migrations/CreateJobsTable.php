<?php

namespace App\Migrations;

use App\Core\Database;

class CreateJobsTable
{
    public function up()
    {
        $db = Database::connect();
        $sql = "CREATE TABLE IF NOT EXISTS job (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            job_category_id INT NOT NULL,
            job_level_id INT NOT NULL,
            created_by INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (job_category_id) REFERENCES job_categories(id) ON DELETE CASCADE,
            FOREIGN KEY (job_level_id) REFERENCES job_level(id) ON DELETE CASCADE,
            FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
        )";
        $db->exec($sql);
    }

    public function down()
    {
        $db = Database::connect();
        $sql = "DROP TABLE IF EXISTS job";
        $db->exec($sql);
    }
}
