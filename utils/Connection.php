<?php

class Connection extends PDO
{
    private static $instance = null;
    private $dbPath = __DIR__ . '/../database/RIS.db';
    private $dsn;
    private function __construct()
    {
        $this->dsn = "sqlite:" . $this->dbPath;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            parent::__construct($this->dsn, null, null, $options);
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