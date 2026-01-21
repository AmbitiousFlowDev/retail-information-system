<?php

require_once 'Model.php';

final class Audit extends Model
{
    protected string $table = 'Audit';
    protected string $primaryKey = 'audit_id';

    /**
     * Get all audit logs with user information
     */
    public function allWithUsers()
    {
        $sql = "
            SELECT 
                a.audit_id,
                a.action_type,
                a.action_date,
                a.description,
                u.username,
                CONCAT(e.first_name, ' ', e.last_name) as employee_name
            FROM {$this->table} a
            LEFT JOIN User u ON a.user_id = u.user_id
            LEFT JOIN Employee e ON u.employee_id = e.employee_id
            WHERE a.deleted_at IS NULL
            ORDER BY a.action_date DESC
        ";

        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Get recent audit logs (last N entries)
     */
    public function recent(int $limit = 50)
    {
        $sql = "
            SELECT 
                a.audit_id,
                a.action_type,
                a.action_date,
                a.description,
                u.username
            FROM {$this->table} a
            LEFT JOIN User u ON a.user_id = u.user_id
            WHERE a.deleted_at IS NULL
            ORDER BY a.action_date DESC
            LIMIT {$limit}
        ";

        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Get audit logs by user
     */
    public function byUser(int $userId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE user_id = ? AND deleted_at IS NULL
            ORDER BY action_date DESC
        ");
        $stmt->execute([$userId]);

        return $stmt->fetchAll();
    }

    /**
     * Get audit logs by action type
     */
    public function byActionType(string $actionType)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE action_type = ? AND deleted_at IS NULL
            ORDER BY action_date DESC
        ");
        $stmt->execute([$actionType]);

        return $stmt->fetchAll();
    }
}
