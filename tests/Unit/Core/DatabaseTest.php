<?php

namespace Tests\Unit\Core;

use App\Core\Database;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testDatabaseConnection()
    {
        $pdo = $this->createMock(PDO::class);
        $pdo->method('prepare')->willReturn($this->createMock(PDOStatement::class));

        Database::connect();
        $this->assertNotNull(Database::connect());
    }

    public function testQueryExecution()
    {
        $pdoStatement = $this->createMock(PDOStatement::class);
        $pdoStatement->method('execute')->willReturn(true);
    
        $pdo = $this->createMock(PDO::class);
        $pdo->method('prepare')->willReturn($pdoStatement);
    
        Database::connect(); 
        $result = Database::exec('SELECT * FROM users WHERE id = :id', ['id' => 1]);
    
        $this->assertInstanceOf(PDOStatement::class, $result);
    }
    
}
