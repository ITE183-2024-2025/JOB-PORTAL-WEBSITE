<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class BaseRepository
{
    protected $pdo;
    protected $table;

    public function __construct($table)
    {
        $this->pdo = Database::connect();
        $this->table = $table;
    }

    /**
     * Create a new record in the table.
     *
     * @param array $data
     * @return bool
     */
    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(
            ', ',
            array_map(fn($key) => ":$key", array_keys($data))
        );
        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Update a record by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        $fields = implode(
            ', ',
            array_map(fn($key) => "$key = :$key", array_keys($data))
        );
        $data['id'] = $id;
        $query = "UPDATE {$this->table} SET $fields WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Delete a record by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Fetch all records from the table.
     *
     * @return array
     */
    public function all()
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find a record by ID.
     *
     * @param int $id
     * @return array|null
     */
    public function find($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find a record by a specific column and value.
     *
     * @param string $column
     * @param mixed $value
     * @return array|null
     */
    public function findBy($column, $value)
    {
        $query = "SELECT * FROM {$this->table} WHERE $column = :value";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['value' => $value]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch all records matching specific conditions.
     *
     * @param array $conditions
     * @return array
     */
    public function where(array $conditions)
    {
        $query = "SELECT * FROM {$this->table} WHERE " . implode(
            ' AND ',
            array_map(fn($key) => "$key = :$key", array_keys($conditions))
        );
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($conditions);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count records in the table.
     *
     * @return int
     */
    public function count()
    {
        $query = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->pdo->query($query);
        return (int) $stmt->fetchColumn();
    }
}
