<?php

require_once "../utils/Connection.php";
require_once "../models/Client.php";

try {
    $connection = Connection::getInstance();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

try {
    $client = new Client();
    print_r($client->all());
    print_r($client->find(1));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}


?>