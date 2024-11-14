<?php
require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    $_ENV['DB_HOST'] = $_ENV['DB_HOST'] ?? '127.0.0.1';
    $_ENV['DB_NAME'] = $_ENV['DB_NAME'] ?? 'test_db';
    $_ENV['DB_USER'] = $_ENV['DB_USER'] ?? 'root';
    $_ENV['DB_PASSWORD'] = $_ENV['DB_PASSWORD'] ?? '';
}

return [
    'db' => [
        'host' => $_ENV['DB_HOST'],
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
];
