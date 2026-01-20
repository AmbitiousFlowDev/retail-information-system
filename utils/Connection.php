<?php

class Connection extends PDO
{
    private static $instance = null;
    private $dsn = "sqlite:../database/retail_info_sys.db";
    private function __construct()
    {
        $dsn = $this->dsn;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        parent::__construct($dsn, null, null, $options);
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
    }
}