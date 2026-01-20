<?php
require_once 'models/User.php';

trait AuthTrait
{
    public function checkAuth(): bool
    {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }
    public function requireAuth(): void
    {
        if (!$this->checkAuth()) {
            header("Location: login.php");
            exit;
        }
    }
    public function currentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
    public function authenticate(string $username, string $password): bool
    {
        $userModel = new User();
        $user = $userModel->findByCredentials($username, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }
    public function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
        header("Location: login.php");
        exit;
    }
}
