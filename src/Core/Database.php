<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $pdo = null;

    public static function connect()
    {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../../config/config.php';
            $host = $config['db']['host'];
            $db = $config['db']['dbname'];
            $user = $config['db']['user'];
            $pass = $config['db']['password'];

            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
