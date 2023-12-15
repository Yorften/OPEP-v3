<?php
session_start();

class Connection
{
    private static $instance;
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "opep2";
    private $conn;

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
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
