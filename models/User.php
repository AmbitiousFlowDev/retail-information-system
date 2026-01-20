<?php
require_once 'Model.php';

class User extends Model
{
    protected string $table = 'User';

    public function all()
    {
        $sql = "
            SELECT id, firstname, lastname, username, type
            FROM {$this->table}
            WHERE deleted_at IS NULL
        ";

        return $this->db->query($sql)->fetchAll();
    }

    public function create(array $data)
    {
        $data['password'] = md5($data['password']);

        $sql = "
            INSERT INTO {$this->table}
            (firstname, lastname, username, password, type)
            VALUES (:firstname, :lastname, :username, :password, :type)
        ";

        return $this->db->prepare($sql)->execute($data);
    }

    public function findByCredentials(string $username, string $password)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM {$this->table}
            WHERE username = ?
              AND password = ?
              AND deleted_at IS NULL
        ");

        $stmt->execute([$username, md5($password)]);
        return $stmt->fetch();
    }
}
