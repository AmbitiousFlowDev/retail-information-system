<?php
require_once 'Model.php';

final class Employee extends Model
{
    protected string $table = 'Employee';
    protected string $primaryKey = 'employee_id';

    public function allWithRoles()
    {
        $sql = "
            SELECT e.*, r.role_code
            FROM {$this->table} e
            LEFT JOIN Role r ON e.role_id = r.role_id
            WHERE e.deleted_at IS NULL
        ";
        return $this->db->query($sql)->fetchAll();
    }
}
