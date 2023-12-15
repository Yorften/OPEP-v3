<?php

require_once 'conn.php';
require_once 'Category.php';
class Categories
{
    private $db;
    public function __construct()
    {
        $this->db = Connection::getInstance()->getConnection();
    }

    public function getCategories()
    {
        $query = "SELECT * FROM categoreis";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $CategoriesData = $stmt->fetchAll();
        $Categories = array();
        foreach ($CategoriesData as $B) {
            $Categories[] = new Category($B["categoryId"], $B["categoryName"]);
        }
        return $Categories;
    }
    public function getCategoriesPage($start, $rows_per_page)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories LIMIT ?,?");
        $stmt->bindParam(1, $start, PDO::PARAM_INT);
        $stmt->bindParam(2, $rows_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $CategoriesData = $stmt->fetchAll();
        $Categories = array();
        foreach ($CategoriesData as $B) {
            $Categories[] = new Category($B["categoryId"], $B["categoryName"]);
        }
        return $Categories;
    }
}
