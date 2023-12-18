<?php

require_once 'conn.php';
require_once 'Category.php';

class CategoryDAO
{
    private $db;
    private Category $Category;
    public function __construct()
    {
        $this->db = Connection::getInstance()->getConnection();
        $this->Category = new Category();
    }

    public function getCategory()
    {
        return $this->Category;
    }

    public function getCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $Categories = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->Category = new Category();
            $this->Category->setId($row['categoryId']);
            $this->Category->setName($row['categoryName']);
            array_push($Categories, $this->Category);
        }
        return $Categories;
    }
    public function getCategoriesPage($start, $rows_per_page)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories LIMIT ?,?");
        $stmt->bindParam(1, $start, PDO::PARAM_INT);
        $stmt->bindParam(2, $rows_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $Categories = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->Category = new Category();
            $this->Category->setId($row['categoryId']);
            $this->Category->setName($row['categoryName']);
            array_push($Categories, $this->Category);
        }
        return $Categories;
    }

    public function categoryExists()
    {
        $name = $this->Category->getName();
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE categoryName = ?");
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function addCategory()
    {
        $name = $this->Category->getName();
        try {
            $stmt = $this->db->prepare("INSERT INTO categories (categoryName) VALUES (?)");
            $stmt->bindParam(1, $name, PDO::PARAM_STR);
            $stmt->execute();
            $result = true;
        } catch (PDOException $e) {
            echo "Database error : " . $e->getMessage();
            $result = false;
        }
        return $result;
    }

    public function modifyCategory()
    {
        $id = $this->Category->getId();
        $name = $this->Category->getName();
        try {
            $stmt = $this->db->prepare("UPDATE categories SET categoryName = ? WHERE categoryId = ?");
            $stmt->bindParam(1, $name, PDO::PARAM_STR);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Database error : " . $e->getMessage();
            return false;
        }
    }
}
