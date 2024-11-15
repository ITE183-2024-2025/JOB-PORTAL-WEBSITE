<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Scripts\MigrationRunner;

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
                $pdo = new PDO("mysql:host=$host", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Check if the database exists and create it if not
                $result = $pdo->query("SHOW DATABASES LIKE '$db'");
                if ($result->rowCount() == 0) {
                    $pdo->exec("CREATE DATABASE `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                }

                // Connect to the specified database
                self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new \Exception("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function exec($sql, array $params = [])
    {
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
