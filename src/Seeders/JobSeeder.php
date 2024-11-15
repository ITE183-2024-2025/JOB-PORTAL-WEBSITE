<?php

namespace App\Seeders;

use App\Core\Database;

class JobSeeder
{
    public function run()
    {
        $db = Database::connect();

        $jobs = [
            [
                'name' => 'Software Engineer',
                'job_category_id' => 1, // Engineering
                'job_level_id' => 2, // Mid Level
                'created_by' => 1, // User ID
            ],
            [
                'name' => 'Marketing Specialist',
                'job_category_id' => 2, // Marketing
                'job_level_id' => 1, // Entry Level
                'created_by' => 2, // User ID
            ],
        ];

        foreach ($jobs as $job) {
            $stmt = $db->prepare(
                "INSERT INTO job (name, job_category_id, job_level_id, created_by) 
                VALUES (:name, :job_category_id, :job_level_id, :created_by)"
            );
            $stmt->execute($job);
        }
    }
}
