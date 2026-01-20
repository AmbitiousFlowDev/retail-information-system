<?php
require_once '../utils/Connection.php';

abstract class Model
{
    protected $db;
    protected string $table;
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
            WHERE id = ? AND deleted_at IS NULL
        ");
        $stmt->execute([$id]);

        return $stmt->fetch();
    }
    public function delete(int $id)
    {
        return $this->db
            ->prepare("UPDATE {$this->table} SET deleted_at = NOW() WHERE id = ?")
            ->execute([$id]);
    }
    public function restore(int $id)
    {
        return $this->db
            ->prepare("UPDATE {$this->table} SET deleted_at = NULL WHERE id = ?")
            ->execute([$id]);
    }
}
