<?php
require_once 'Model.php';

class Product extends Model
{
    protected string $table = 'Product';

    public function updatePrice(int $id, float $price)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET unit_price = ?
            WHERE id = ? AND deleted_at IS NULL
        ");

        return $stmt->execute([$price, $id]);
    }
}
