<?php

require_once('conn.php');


class Pages
{
    private $conn;
    private $start;
    private $rows;
    private $rows_per_page;
    private $pages;

    public function getStart()
    {
        return $this->start;
    }

    public function getRows()
    {
        return $this->rows;
    }
    public function getRows_per_page()
    {
        return $this->rows_per_page;
    }
    public function getPages()
    {
        return $this->pages;
    }

    public function __construct(){
        $this->conn = Connection::getInstance()->getConnection(); 
    }

    public function getPagesDetails($start, $rows_per_page, $tablename, $args)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $tablename $args");
            $stmt->execute();
            $rows = $stmt->rowCount();
            $this->rows = $stmt->rowCount();
            $this->start = $start;
            $this->rows_per_page = $rows_per_page;
            if (isset($_GET['page'])) {
                $page = $_GET['page'] - 1;
                $this->start = $page * $rows_per_page;
            }
            $this->pages = ceil($rows / $rows_per_page);
        } catch (PDOException $e) {
            echo "Database error : " . $e->getMessage();
        }
    }
}
