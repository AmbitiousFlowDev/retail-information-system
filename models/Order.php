<?php
require_once 'Model.php';

class Order extends Model
{
    protected string $table = 'Order';

    public function findByClient(int $clientId)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM {$this->table}
            WHERE client_id = ?
              AND deleted_at IS NULL
        ");

        $stmt->execute([$clientId]);
        return $stmt->fetchAll();
    }
}
