<?php

require_once 'vendor/autoload.php';

use App\Migrations\CreateUsersTable;

$migrations = [
    new CreateUsersTable(),
];

foreach (array_reverse($migrations) as $migration) {
    echo "Rolling back " . get_class($migration) . "...\n";
    $migration->down();
    echo "Migration " . get_class($migration) . " rolled back successfully.\n";
}
