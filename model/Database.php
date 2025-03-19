<?php
// model/Database.php

class Database {
    private $connection;
    
    public function __construct($dbFile) {
        $this->connection = new PDO("sqlite:" . $dbFile);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>