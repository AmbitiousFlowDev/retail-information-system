<?php
require_once 'utils/Connection.php';

class Order
{
    protected string $table = 'orders';
    protected $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function all()
    {
        return $this->db->query("SELECT * FROM {$this->table}")->fetchAll();
    }

    public function find(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table}
                (sales_code, client, amount, remarks, stock_ids)
                VALUES (:sales_code, :client, :amount, :remarks, :stock_ids)";
        
        return $this->db->prepare($sql)->execute($data);
    }

    public function delete(int $id)
    {
        return $this->db
            ->prepare("DELETE FROM {$this->table} WHERE id=?")
            ->execute([$id]);
    }
}