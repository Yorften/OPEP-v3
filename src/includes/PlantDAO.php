<?php

require_once 'conn.php';
require_once 'Plant.php';
class PlantDAO
{
    private $db;
    private Plant $Plant;
    public function __construct()
    {
        $this->db = Connection::getInstance()->getConnection();
        $this->Plant = new Plant();
    }

    public function getObject()
    {
        return $this->Plant;
    }

    public function getPlants()
    {
        $query = "SELECT * FROM plants JOIN categories ON plants.categoryId = categories.categoryId";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $Plants = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->Plant = new Plant();
            $this->Plant->setId($row['plantId']);
            $this->Plant->setName($row['plantName']);
            $this->Plant->setDesc($row['plantDesc']);
            $this->Plant->setImage($row['plantImage']);
            $this->Plant->setPrice($row['plantPrice']);
            $this->Plant->setCategory($row['categoryName']);
            array_push($Plants, $this->Plant);
        }
        return $Plants;
    }
    public function getPlantsPage($start, $rows_per_page)
    {
        $stmt = $this->db->prepare("SELECT * FROM plants JOIN categories ON plants.categoryId = categories.categoryId LIMIT ?,?");
        $stmt->bindParam(1, $start, PDO::PARAM_INT);
        $stmt->bindParam(2, $rows_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $Plants = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->Plant = new Plant();
            $this->Plant->setId($row['plantId']);
            $this->Plant->setName($row['plantName']);
            $this->Plant->setDesc($row['plantDesc']);
            $this->Plant->setImage($row['plantImage']);
            $this->Plant->setPrice($row['plantPrice']);
            $this->Plant->setCategory($row['categoryName']);
            array_push($Plants, $this->Plant);
        }
        return $Plants;
    }

    public function getPlantsCategoryPage($start, $rows_per_page)
    {
        $id = $this->getObject()->getCategory();
        $stmt = $this->db->prepare("SELECT * FROM plants JOIN categories ON plants.categoryId = categories.categoryId WHERE plants.categoryId = ? LIMIT ?,?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $start, PDO::PARAM_INT);
        $stmt->bindParam(3, $rows_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $Plants = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->Plant = new Plant();
            $this->Plant->setId($row['plantId']);
            $this->Plant->setName($row['plantName']);
            $this->Plant->setDesc($row['plantDesc']);
            $this->Plant->setImage($row['plantImage']);
            $this->Plant->setPrice($row['plantPrice']);
            $this->Plant->setCategory($row['categoryName']);
            array_push($Plants, $this->Plant);
        }
        return $Plants;
    }

    public function plantExists()
    {
        $name = $this->Plant->getName();
        $stmt = $this->db->prepare("SELECT * FROM plants WHERE plantName = ?");
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function plantExistsModify()
    {
        $id = $this->Plant->getId();
        $name = $this->Plant->getName();
        $stmt = $this->db->prepare("SELECT * FROM plants WHERE plantName = ? AND plantId != ?");
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function addPlant( Plant $plant)
    {
        $name = $plant->getName();
        $desc = $plant->getDesc();
        $image = $plant->getImage();
        $price = $plant->getPrice();
        $category = $plant->getCategory();
        try {
            $stmt = $this->db->prepare("INSERT INTO plants (plantName,plantDesc,plantImage,plantPrice,categoryId) VALUES (?,?,?,?,?)");
            $stmt->bindParam(1, $name, PDO::PARAM_STR);
            $stmt->bindParam(2, $desc, PDO::PARAM_STR);
            $stmt->bindParam(3, $image, PDO::PARAM_STR);
            $stmt->bindParam(4, $price, PDO::PARAM_INT);
            $stmt->bindParam(5, $category, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Database error : " . $e->getMessage();
            return false;
        }
    }

    public function modifyPlant()
    {
        $id = $this->Plant->getId();
        $name = $this->Plant->getName();
        $desc = $this->Plant->getDesc();
        $price = $this->Plant->getPrice();
        $category = $this->Plant->getCategory();
        try {
            $stmt = $this->db->prepare("UPDATE plants SET plantName = ?, plantDesc = ?, plantPrice = ?, categoryId = ? WHERE plantId = ?");
            $stmt->bindParam(1, $name, PDO::PARAM_STR);
            $stmt->bindParam(2, $desc, PDO::PARAM_STR);
            $stmt->bindParam(3, $price, PDO::PARAM_INT);
            $stmt->bindParam(4, $category, PDO::PARAM_INT);
            $stmt->bindParam(5, $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Database error : " . $e->getMessage();
            return false;
        }
    }

    public function modifyPlantImage()
    {
        $id = $this->Plant->getId();
        $name = $this->Plant->getName();
        $desc = $this->Plant->getDesc();
        $image = $this->Plant->getImage();
        $price = $this->Plant->getPrice();
        $category = $this->Plant->getCategory();
        try {
            $stmt = $this->db->prepare("UPDATE plants SET plantName = ?, plantDesc = ?, plantImage = ?, plantPrice = ?, categoryId = ? WHERE plantId = ?");
            $stmt->bindParam(1, $name, PDO::PARAM_STR);
            $stmt->bindParam(2, $desc, PDO::PARAM_STR);
            $stmt->bindParam(3, $image, PDO::PARAM_STR);
            $stmt->bindParam(4, $price, PDO::PARAM_INT);
            $stmt->bindParam(5, $category, PDO::PARAM_INT);
            $stmt->bindParam(6, $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Database error : " . $e->getMessage();
            return false;
        }
    }

    public function deletePlant()
    {
        $id = $this->Plant->getId();
        try {
            $stmt = $this->db->prepare("DELETE FROM plants WHERE plantId = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Database error : " . $e->getMessage();
            return false;
        }
    }
}
