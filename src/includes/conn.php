<?php
session_start();

class Connection
{
    public $host = "localhost";
    public $user = "root";
    public $password = "";
    public $database = "opep2";
    public $conn;

    public function __construct()
    {
        try {
            $dbh = "mysql:host={$this->host};dbname={$this->database}";
            $this->conn = new PDO($dbh, $this->user, $this->password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}


