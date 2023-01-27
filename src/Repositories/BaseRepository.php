<?php

namespace Appsas\Repositories;

use Appsas\Database;
use Appsas\Exceptions\ForeignKeyException;
use PDOException;
use RuntimeException;

class BaseRepository
{
    protected const TABLE_NAME = null;

    private array $tableColumnsData;

    public function __construct(protected Database $db)
    {
    }

    public function create(array $data): void
    {
        //
        $tableName = $this->getTableName();
        $columnsData = $this->getTableColumnsData();
        $columns = array_map(fn($column) => $column['Field'], $columnsData);

        // Pašalinam pirminio rakto stulpeli is masyvo
        $primaryKey = $this->getPrimaryKey();
        $columns = array_filter($columns, fn($column) => $column !== $primaryKey);

        $backTickedColumns = array_map(fn($value) => "`$value`", $columns);
        $mergedColumns = implode(', ', $backTickedColumns);

        $values = array_map(fn($value) => ":$value", $columns);
        $values = implode(', ', $values);

        $sql = "INSERT INTO $tableName ($mergedColumns) VALUES ($values)";
        $this->db->query($sql, $data);
    }

    public function findById(int $id): array
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM $tableName WHERE id = :id";
        return $this->db->query($sql, ['id' => $id])[0];
    }

    public function update(array $data): void
    {
        $tableName = $this->getTableName();
        $columnsData = $this->getTableColumnsData();
        $columns = array_map(fn($column) => $column['Field'], $columnsData);

        // Pašalinam pirminio rakto stulpeli is masyvo
        $primaryKey = $this->getPrimaryKey();
        $columns = array_filter($columns, fn($column) => $column !== $primaryKey);

        $columns = array_map(fn($value) => "$value = :$value", $columns);
        $columns = implode(', ', $columns);
        $sql = "UPDATE $tableName SET $columns WHERE id = :id";
        $this->db->query($sql, $data);
    }

    /**
     * @throws ForeignKeyException
     */
    public function delete(int $id): void
    {
        try {
            $tableName = $this->getTableName();
            $sql = "DELETE FROM $tableName WHERE id = :id";
            $this->db->query($sql, ['id' => $id]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1451) {
                throw new ForeignKeyException(message:'Record is used in other tables', exception: $e);
            } else {
                throw $e;
            }
        }

    }

    public function all(): array
    {
        $tableName = $this->getTableName();
        return $this->db->query("SELECT * FROM $tableName");
    }

    protected function getTableName(): string
    {
        return static::TABLE_NAME ?? throw new RuntimeException('Table name not set');
    }

    private function getTableColumnsData(): array
    {
        $tableName = $this->getTableName();

        if (!isset($this->tableColumnsData)) {
            $this->tableColumnsData = $this->db->getTableColumnsData($tableName);
        }
        return $this->tableColumnsData;
    }

    private function getPrimaryKey()
    {
        $columnsData = $this->getTableColumnsData();
        $primaryKey = array_filter($columnsData, fn($column) => $column['Key'] === 'PRI');
        $primaryKey = array_shift($primaryKey);
        return $primaryKey['Field'];
    }
}