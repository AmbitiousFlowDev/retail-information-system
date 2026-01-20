<?php

require_once "init.php";

class Connection extends PDO {
    private static $instance = null;
    private $host     = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    private function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        parent::__construct($dsn, $this->username, $this->password, $options);
    }
    public static function getInstance(): Connection {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }
    private function __clone() {}
}