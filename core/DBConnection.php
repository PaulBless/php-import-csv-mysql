<?php

## Local Database Parameters
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_DATABASE','import_csv_db');


# Remote Database Parameters

class DatabaseConnection
{
    public function __construct()
    {
        $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

        if($connection->connect_error)
        {
            die ("<h1 style='color: red;'>Error!! Database Connection Failed</h1>");
            die($connection->connect_error);
        }

        //echo "Database Connected Successfully";
        return $this->connection = $connection;
    }
}

?>