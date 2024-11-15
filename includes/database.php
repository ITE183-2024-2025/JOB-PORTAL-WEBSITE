<?php

use App\Core\Database;
use App\Scripts\MigrationRunner;

/**
 * Initialize the database with migrations and seeders if required.
 */
function initializeDatabaseIfRequired(): void
{
    if (!isDatabaseInitialized()) {
        Database::connect();
        MigrationRunner::runMigrations();
        MigrationRunner::runSeeders();
    }
}

/**
 * Check if the database is already initialized.
 *
 * @return bool
 */
function isDatabaseInitialized(): bool
{
    try {
        $pdo = Database::connect();
        $stmt = $pdo->query("SHOW TABLES LIKE 'migrations'");
        if ($stmt->rowCount() === 0) {
            return false;
        }

        $stmt = $pdo->query("SELECT COUNT(*) FROM migrations");
        $count = (int) $stmt->fetchColumn();
        return $count > 0;
    } catch (Exception $e) {
        return false;
    }
}
