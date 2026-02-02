<?php

final class User extends Model
{
    protected string $table = 'User';
    protected string $primaryKey = 'user_id';

    public function allWithEmployees()
    {
        $sql = "
            SELECT 
                u.user_id,
                u.username,
                u.user_category,
                u.employee_id,
                CONCAT(e.first_name, ' ', e.last_name) as employee_name
            FROM {$this->table} u
            LEFT JOIN Employee e ON u.employee_id = e.employee_id
            WHERE u.deleted_at IS NULL
        ";

        return $this->db->query($sql)->fetchAll();
    }

    public function all()
    {
        $sql = "
            SELECT user_id, username, user_category, employee_id
            FROM {$this->table}
            WHERE deleted_at IS NULL
        ";

        return $this->db->query($sql)->fetchAll();
    }

    public function createUser(array $data)
    {
        $sql = "INSERT INTO {$this->table} (username, password_hash, user_category, employee_id) 
                VALUES (:username, :password_hash, :user_category, :employee_id)";
        return $this->db->prepare($sql)->execute($data);
    }

    /**
     * Find user by credentials and return UserInterface (Factory creates concrete type).
     * Joins Employee and Role so Factory can use role_code and user_category.
     */
    public function findByCredentials(string $username, string $password): ?UserInterface
    {
        $sql = "
            SELECT u.user_id, u.username, u.user_category, u.employee_id, r.role_code
            FROM {$this->table} u
            INNER JOIN Employee e ON e.employee_id = u.employee_id AND e.deleted_at IS NULL
            INNER JOIN Role r ON r.role_id = e.role_id AND r.deleted_at IS NULL
            WHERE u.username = ? AND u.password_hash = ? AND u.deleted_at IS NULL
            LIMIT 1
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username, md5($password)]);
        $data = $stmt->fetch();

        return $data ? UserFactory::create($data) : null;
    }
}