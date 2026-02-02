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

    public function findByCredentials(string $username, string $password): ? UserInterface
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ? AND password_hash = ? AND deleted_at IS NULL");
        $stmt->execute([$username, md5($password)]);
        $data = $stmt->fetch();

        return $data ? UserFactory::create($data) : null;
    }
}