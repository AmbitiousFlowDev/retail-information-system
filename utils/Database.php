<?php



class Connection extends PDO {
    private $host     = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;

    public function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=utf8mb4";
        parent::__construct($dsn, $this->username, $this->password);
    }
}