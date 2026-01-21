<?php
require_once 'Model.php';

final class Order extends Model
{
    protected string $table = '`Order`';
    protected string $primaryKey = 'order_id';

    public function allWithDetails()
    {
        $sql = "
            SELECT 
                o.order_id,
                o.order_date,
                CONCAT(c.first_name, ' ', c.last_name) as client_name,
                CONCAT(e.first_name, ' ', e.last_name) as employee_name,
                c.client_id,
                e.employee_id
            FROM {$this->table} o
            LEFT JOIN Client c ON o.client_id = c.client_id
            LEFT JOIN Employee e ON o.employee_id = e.employee_id
            WHERE o.deleted_at IS NULL
            ORDER BY o.order_date DESC
        ";
        return $this->db->query($sql)->fetchAll();
    }

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
