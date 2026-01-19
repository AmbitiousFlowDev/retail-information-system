<?php
require_once 'models/Utilisateur.php';

class Auth
{
    public static function attempt(string $username, string $password): bool
    {
        $userModel = new Utilisateur();
        
        // Find user by credentials
        $user = $userModel->findByCredentials($username, $password);

        if ($user) {
            self::startSession();
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }
    public static function user()
    {
        self::startSession();
        return $_SESSION['user'] ?? null;
    }
    public static function check(): bool
    {
        return self::user() !== null;
    }
    public static function logout()
    {
        self::startSession();
        unset($_SESSION['user']);
        session_destroy();
    }
    private static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}