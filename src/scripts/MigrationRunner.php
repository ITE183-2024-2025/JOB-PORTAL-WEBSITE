<?php

namespace App\Scripts;

use App\Core\Database;
use App\Migrations\CreateUsersTable;
use App\Migrations\CreateJobsTable;
use App\Migrations\CreateJobCategoriesTable;
use App\Migrations\CreateJobLevelsTable;
use App\Migrations\CreateApplicationsTable;
use App\Migrations\CreateMigrationsTable;
use App\Seeders\UserSeeder;
use App\Seeders\JobCategorySeeder;
use App\Seeders\JobLevelSeeder;
use App\Seeders\JobSeeder;
use App\Seeders\ApplicationSeeder;

class MigrationRunner
{
    protected static $migrations = [
        CreateUsersTable::class,
        CreateJobCategoriesTable::class,
        CreateJobLevelsTable::class,
        CreateJobsTable::class,
        CreateApplicationsTable::class,
    ];

    protected static $seeders = [
        UserSeeder::class,
        JobCategorySeeder::class,
        JobLevelSeeder::class,
        JobSeeder::class,
        ApplicationSeeder::class,
    ];

    private static function recordMigration($migration)
    {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO migrations (migration, batch) VALUES (:migration, :batch)");
        $stmt->execute([
            ':migration' => $migration,
            ':batch' => 1,
        ]);
    }

    private static function isMigrationRecorded($migration)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT migration FROM migrations WHERE migration = :migration");
        $stmt->execute([':migration' => $migration]);
        return $stmt->rowCount() > 0;
    }

    public static function runMigrations()
    {
        $migrationsTable = new CreateMigrationsTable();
        $migrationsTable->up();

        foreach (self::$migrations as $migrationClass) {
            $migration = new $migrationClass();
            $migrationName = get_class($migration);
            if (!self::isMigrationRecorded($migrationName)) {
                $migration->up();
                self::recordMigration($migrationName);
            }
        }

        self::runSeeders();
    }

    public static function runSeeders()
    {
        foreach (self::$seeders as $seederClass) {
            $seeder = new $seederClass();
            $seeder->run();
        }
    }

    public static function rollbackMigrations()
    {
        $reverseMigrations = array_reverse(self::$migrations);
        foreach ($reverseMigrations as $migrationClass) {
            $migration = new $migrationClass();
            $migrationName = get_class($migration);
            if (self::isMigrationRecorded($migrationName)) {
                $migration->down();
                self::removeMigrationRecord($migrationName);
            }
        }

        $migrationsTable = new CreateMigrationsTable();
        $migrationsTable->down();
    }

    private static function removeMigrationRecord($migration)
    {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM migrations WHERE migration = :migration");
        $stmt->execute([':migration' => $migration]);
    }
}
