<?php
require_once 'utils/Connection.php';

class Client
{
    protected string $table = 'clients';
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
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table}
                (name, address, cperson, contact, status)
                VALUES (:name, :address, :cperson, :contact, :status)";
        
        return $this->db->prepare($sql)->execute($data);
    }

    public function update(int $id, array $data)
    {
        $sql = "UPDATE {$this->table}
                SET name=:name, address=:address, cperson=:cperson,
                    contact=:contact, status=:status
                WHERE id=:id";
        $data['id'] = $id;
        
        return $this->db->prepare($sql)->execute($data);
    }

    public function delete(int $id)
    {
        return $this->db
            ->prepare("DELETE FROM {$this->table} WHERE id = ?")
            ->execute([$id]);
    }
}