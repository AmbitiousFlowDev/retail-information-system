<?php
require_once 'utils/Connection.php';

class Stock
{
    protected string $table = 'stock_list';
    protected $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function all()
    {
        return $this->db->query("
            SELECT s.*, p.name AS produit
            FROM stock_list s
            JOIN produits p ON p.id = s.item_id
        ")->fetchAll();
    }

    public function create(array $data)
    {
        $data['total'] = $data['quantity'] * $data['price'];

        $sql = "INSERT INTO {$this->table}
                (item_id, quantity, unit, price, total, type)
                VALUES (:item_id, :quantity, :unit, :price, :total, :type)";
        
        return $this->db->prepare($sql)->execute($data);
    }

    public function getStockByProduct(int $itemId): int
    {
        $sql = "
            SELECT 
              SUM(CASE WHEN type=1 THEN quantity ELSE 0 END) -
              SUM(CASE WHEN type=2 THEN quantity ELSE 0 END) AS stock
            FROM stock_list
            WHERE item_id=?
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$itemId]);
        return (int) ($stmt->fetch()['stock'] ?? 0);
    }
}