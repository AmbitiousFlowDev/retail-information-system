<?php

class Role extends Model
{
    protected string $table = "Role";      // Table name
    protected string $primaryKey = "role_id"; // Primary key column
    // Optionally, you can add helper methods specific to Role
    public function findByCode(string $roleCode)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE role_code = ? LIMIT 1");
        $stmt->execute([$roleCode]);
        return $stmt->fetch();
    }
}
