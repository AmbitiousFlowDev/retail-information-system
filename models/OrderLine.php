<?php
require_once 'Model.php';

final class OrderLine extends Model
{
    protected string $table = 'OrderLine';

    public function findByOrderIdAndProductId(int $orderId, int $productId)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM {$this->table}
            WHERE order_id = ? AND product_id = ? AND deleted_at IS NULL
        ");
        $stmt->execute([$orderId, $productId]);
        return $stmt->fetch();
    }
    public function deleteByOrderIdAndProductId(int $orderId, int $productId)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET deleted_at = datetime('now')
            WHERE order_id = ? AND product_id = ?
        ");
        return $stmt->execute([$orderId, $productId]);
    }
    public function updateByOrderIdAndProductId(int $orderId, int $productId, array $data)
    {
        $columns = array_keys($data);
        $assignments = implode(", ", array_map(fn($col) => "$col = :$col", $columns));

        $sql = "
            UPDATE {$this->table}
            SET $assignments
            WHERE order_id = :order_id AND product_id = :product_id
              AND deleted_at IS NULL
        ";

        $stmt = $this->db->prepare($sql);
        $data['order_id'] = $orderId;
        $data['product_id'] = $productId;

        return $stmt->execute($data);
    }
}
