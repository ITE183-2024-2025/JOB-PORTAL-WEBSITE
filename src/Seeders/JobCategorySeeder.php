<?php

namespace App\Seeders;

use App\Core\Database;

class JobCategorySeeder
{
    public function run()
    {
        $db = Database::connect();

        $categories = [
            ['name' => 'Engineering', 'other_details' => 'Engineering-related jobs'],
            ['name' => 'Marketing', 'other_details' => 'Marketing-related jobs'],
            ['name' => 'Sales', 'other_details' => 'Sales-related jobs'],
        ];

        foreach ($categories as $category) {
            $stmt = $db->prepare("INSERT INTO job_categories (name, other_details) VALUES (:name, :other_details)");
            $stmt->execute($category);
        }
    }
}
