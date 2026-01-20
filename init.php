<?php

function get_database($type = "sqlite3")
{
    switch ($type) {
        case "mysql":
            $DB_NAME = "";
            $DB_USER = "";
            $DB_PASSWORD = "";
            $DB_HOST = "localhost";
            $DB_PORT = 3306;
            break;
        default:
            $DB_NAME = "database/retail_info_sys.db";
    }
}