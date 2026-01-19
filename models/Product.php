<?php
require_once 'utils/Connection.php';

class Product
{
    protected string $table = 'products';
    protected $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function all()
    {
        // Note: keeping table alias 'produits' as per original SQL
        return $this->db->query("
            SELECT p.*, c.name AS supplier
            FROM produits p
            JOIN clients c ON c.id = p.supplier_id
        ")->fetchAll();
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
                (name, description, supplier_id, cost, status)
                VALUES (:name, :description, :supplier_id, :cost, :status)";
        
        return $this->db->prepare($sql)->execute($data);
    }

    public function update(int $id, array $data)
    {
        $sql = "UPDATE {$this->table}
                SET name=:name, description=:description,
                    supplier_id=:supplier_id, cost=:cost, status=:status
                WHERE id=:id";
        $data['id'] = $id;
        
        return $this->db->prepare($sql)->execute($data);
    }

    public function delete(int $id)
    {
        return $this->db
            ->prepare("DELETE FROM {$this->table} WHERE id=?")
            ->execute([$id]);
    }
}