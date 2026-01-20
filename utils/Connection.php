<?php

class Connection extends PDO
{
    private static $instance = null;
    private $dsn;
    private function __construct()
    {
        $this->dsn = "mysql:host=localhost;dbname=RIS;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            // - DON'T DO IT :( PLEASE BRO I BEG YOU :'(
            parent::__construct($this->dsn, "root", "753159", $options);
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage() . " (Path: $this->dbPath)");
        }
    }
    public static function getInstance(): Connection
    {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }
    private function __clone()
    {
        // Prevent cloning
    }
}