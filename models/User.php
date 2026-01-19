<?php

require_once 'utils/Connection.php';

class Utilisateur extends Connection
{
    protected string $table = 'users';

    public function all()
    {
        return $this->query("SELECT id, firstname, lastname, username, type FROM {$this->table}")
            ->fetchAll();
    }

    public function find(int $id)
    {
        $stmt = $this->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $data['password'] = md5($data['password']);

        $sql = "INSERT INTO {$this->table}
                (firstname, lastname, username, password, type)
                VALUES (:firstname, :lastname, :username, :password, :type)";
        return $this->prepare($sql)->execute($data);
    }

    public function login(string $username, string $password)
    {
        $stmt = $this->prepare("
            SELECT * FROM {$this->table}
            WHERE username=? AND password=?
        ");
        $stmt->execute([$username, md5($password)]);
        return $stmt->fetch();
    }

    public function delete(int $id)
    {
        return $this
            ->prepare("DELETE FROM {$this->table} WHERE id=?")
            ->execute([$id]);
    }
}
