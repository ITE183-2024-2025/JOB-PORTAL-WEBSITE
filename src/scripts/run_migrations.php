<?php

require_once 'vendor/autoload.php';

use App\Scripts\MigrationRunner;

if (php_sapi_name() === 'cli') {
    $table = 'users';

    if (!MigrationRunner::checkIfTableExists($table)) {
        echo "Table '$table' does not exist. Running migrations...\n";
        MigrationRunner::runMigrations();
        MigrationRunner::runSeeders();
    } else {
        echo "Table '$table' already exists. Skipping migration.\n";
        MigrationRunner::runSeeders();
    }
}
