<?php

namespace iutnc\hellokant\query;

use iutnc\hellokant\database\ConnectionFactory;
use PDO;

class Query
{
    private $table_sql;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';


    public static function table(string $table): Query
    {
        $query = new Query();
        $query->table_sql = $table;
        return $query;
    }


    public function select(array $fields): Query
    {
        $this->fields = implode(',', $fields);
        return $this;
    }


    public function where(string $col, string $op, mixed $val): Query
    {
        $this->where = "WHERE $col $op ?";
        $this->args[] = $val;
        return $this;
    }


    public function get(): array
    {
        $this->sql = 'SELECT ' . $this->fields . ' FROM ' . $this->table_sql;

        if (!is_null($this->where)) {
            $this->sql .= ' ' . $this->where;
        }

        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function delete(): void
    {
        $this->sql = 'DELETE FROM ' . $this->table_sql;

        if (!is_null($this->where)) {
            $this->sql .= ' ' . $this->where;
        }

        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
    }


    public function insert(array $fields): int
    {
        $columns = implode(', ', array_keys($fields));
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));

        $this->sql = 'INSERT INTO ' . $this->table_sql . ' (' . $columns . ') VALUES (' . $placeholders . ')';
        $this->args = array_values($fields);

        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);

        return $pdo->lastInsertId();
    }
}
