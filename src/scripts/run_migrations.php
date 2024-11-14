<?php

require_once 'vendor/autoload.php';

use App\Core\Database;
use App\Migrations\CreateUsersTable;
use App\Seeders\UserSeeder;

class MigrationRunner
{
    public static function checkIfTableExists($tableName)
    {
        $db = Database::connect();
        $query = $db->prepare("SHOW TABLES LIKE :table");
        $query->execute([':table' => $tableName]);
        return $query->rowCount() > 0;
    }

    public static function runMigrations()
    {
        $migrations = [
            new CreateUsersTable(),
        ];

        foreach ($migrations as $migration) {
            echo "Running " . get_class($migration) . "...\n";
            $migration->up();
            echo "Migration " . get_class($migration) . " applied successfully.\n";
        }
    }

    public static function runSeeders()
    {
        $seeders = [
            new UserSeeder(),
        ];

        foreach ($seeders as $seeder) {
            echo "Running " . get_class($seeder) . "...\n";
            $seeder->run();
            echo "Seeder " . get_class($seeder) . " ran successfully.\n";
        }
    }
}

$table = 'users'; 

if (!MigrationRunner::checkIfTableExists($table)) {
    echo "Table '$table' does not exist. Running migrations...\n";
    MigrationRunner::runMigrations();
    MigrationRunner::runSeeders();
} else {
    echo "Table '$table' already exists. Skipping migration.\n";
    MigrationRunner::runSeeders();
}
