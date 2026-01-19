<?php
require_once 'utils/Connection.php';

class Order extends Connection
{
    protected string $table = 'orders';

    public function all()
    {
        return $this->query("SELECT * FROM {$this->table}")->fetchAll();
    }

    public function find(int $id)
    {
        $stmt = $this->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table}
                (sales_code, client, amount, remarks, stock_ids)
                VALUES (:sales_code, :client, :amount, :remarks, :stock_ids)";
        return $this->prepare($sql)->execute($data);
    }

    public function delete(int $id)
    {
        return $this
            ->prepare("DELETE FROM {$this->table} WHERE id=?")
            ->execute([$id]);
    }
}
