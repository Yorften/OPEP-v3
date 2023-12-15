<?php

require_once('conn.php');


class Commands
{
    private $conn;
    public $start;
    public $rows;
    public $rows_per_page;
    public $pages;

    public function __construct(){
        $this->conn = Connection::getInstance()->getConnection(); 
    }

    public function getAllCommands($start, $rows_per_page)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM commands JOIN carts ON commands.cartId = carts.cartId JOIN users ON carts.userId = users.userId LIMIT $start,$rows_per_page");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    public function getCommandedItems($cartId, $commandId, $start, $rows_per_page)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM plants_carts JOIN plants ON plants_carts.plantId = plants.plantId JOIN categories ON plants.categoryId = categories.categoryId WHERE cartId = ? AND isCommanded = ? LIMIT ?,?");
            $stmt->bindParam(1, $cartId, PDO::PARAM_INT);
            $stmt->bindParam(2, $commandId, PDO::PARAM_INT);
            $stmt->bindParam(3, $start, PDO::PARAM_INT);
            $stmt->bindParam(4, $rows_per_page, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Database error : " . $e->getMessage();
        }
    }
}
