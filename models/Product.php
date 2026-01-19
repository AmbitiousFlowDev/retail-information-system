<?php
require_once 'utils/Connection.php';

class Product extends Connection
{
    protected string $table = 'products';

    public function all()
    {
        return $this->query("
            SELECT p.*, c.name AS supplier
            FROM produits p
            JOIN clients c ON c.id = p.supplier_id
        ")->fetchAll();
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
                (name, description, supplier_id, cost, status)
                VALUES (:name, :description, :supplier_id, :cost, :status)";
        return $this->prepare($sql)->execute($data);
    }

    public function update(int $id, array $data)
    {
        $sql = "UPDATE {$this->table}
                SET name=:name, description=:description,
                    supplier_id=:supplier_id, cost=:cost, status=:status
                WHERE id=:id";
        $data['id'] = $id;
        return $this->prepare($sql)->execute($data);
    }

    public function delete(int $id)
    {
        return $this
            ->prepare("DELETE FROM {$this->table} WHERE id=?")
            ->execute([$id]);
    }
}
