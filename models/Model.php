<?php

abstract class Model
{
    protected $db;
    protected string $table;
    protected string $primaryKey = "id";
    public function __construct()
    {
        $this->db = Connection::getInstance();
    }
    public function all()
    {
        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL";
        return $this->db->query($sql)->fetchAll();
    }
    public function find(int $id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE {$this->primaryKey} = ? AND deleted_at IS NULL
        ");
        $stmt->execute([$id]);

        return $stmt->fetch();
    }
    public function delete(int $id)
    {
        return $this->db
            ->prepare("UPDATE {$this->table} SET deleted_at = NOW() WHERE {$this->primaryKey} = ?")
            ->execute([$id]);
    }
    public function restore(int $id)
    {
        return $this->db
            ->prepare("UPDATE {$this->table} SET deleted_at = NULL WHERE id = ?")
            ->execute([$id]);
    }
    public function create(array $data)
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":$col", $columns);

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(", ", $columns),
            implode(", ", $placeholders)
        );

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount() ? (int) $this->db->lastInsertId() : false;
    }
    public function update(int $id, array $data)
    {
        $columns = array_keys($data);
        $assignments = implode(", ", array_map(fn($col) => "$col = :$col", $columns));

        $sql = sprintf(
            "UPDATE %s SET %s WHERE id = :id AND deleted_at IS NULL",
            $this->table,
            $assignments
        );

        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;

        return $stmt->execute($data);
    }
}
