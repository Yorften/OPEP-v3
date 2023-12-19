<?php

require_once 'conn.php';
require_once 'Cart.php';
class CartDAO
{
    private $db;
    private Cart $Cart;

    public function __construct()
    {
        $this->db = Connection::getInstance()->getConnection();
        $this->Cart = new Cart();
    }

    /**
     * Get the value of Cart
     */
    public function getCart()
    {
        return $this->Cart;
    }

    public function getCartRows(Cart $cart)
    {
        $cartId = $cart->getCartId();
        $isSelected = $cart->getIsSelected();
        $isCommanded = $cart->getIsCommanded();
        try {
            $stmt = $this->db->prepare("SELECT * FROM plants_carts JOIN plants ON plants_carts.plantId = plants.plantId WHERE cartId = ? AND isSelected = ? AND isCommanded = ?");
            $stmt->bindParam(1, $cartId, PDO::PARAM_INT);
            $stmt->bindParam(2, $isSelected, PDO::PARAM_INT);
            $stmt->bindParam(3, $isCommanded, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Database Error : " . $e->getMessage();
            return false;
        }
    }

    public function getCartItems(Cart $cart)
    {
        $cartId = $cart->getCartId();
        $isSelected = $cart->getIsSelected();
        $isCommanded = $cart->getIsCommanded();
        try {
            $stmt = $this->db->prepare("SELECT * FROM plants_carts JOIN plants ON plants_carts.plantId = plants.plantId WHERE cartId = ? AND isSelected = ? AND isCommanded = ?");
            $stmt->bindParam(1, $cartId, PDO::PARAM_INT);
            $stmt->bindParam(2, $isSelected, PDO::PARAM_INT);
            $stmt->bindParam(3, $isCommanded, PDO::PARAM_INT);
            $stmt->execute();
            $Items = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->Cart = new Cart();
                $this->Cart->setPlant_CartId($row['plants_cartsId']);
                $this->Cart->setQuantity($row['quantity']);
                $this->Cart->setIsSelected($row['isSelected']);
                $this->Cart->getPlant()->setId($row['plantId']);
                $this->Cart->getPlant()->setName($row['plantName']);
                $this->Cart->getPlant()->setImage($row['plantImage']);
                $this->Cart->getPlant()->setPrice($row['plantPrice']);
                array_push($Items, $this->Cart);
            }
            return $Items;
        } catch (PDOException $e) {
            echo "Database Error : " . $e->getMessage();
        }
    }

    public function removeItem(Cart $cart)
    {
        $cartId = $cart->getCartId();
        $plantId = $cart->getPlant()->getId();
        try {
            $stmt = $this->db->prepare("DELETE FROM plants_carts WHERE cartId = ? AND plantId = ?");
            $stmt->bindParam(1, $cartId, PDO::PARAM_INT);
            $stmt->bindParam(2, $plantId, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } catch (PDOException $e) {
            echo "Database Error : " . $e->getMessage();
        }
    }
    public function removeItems(Cart $cart)
    {
        $cartId = $cart->getCartId();
        try {
            $stmt = $this->db->prepare("DELETE FROM plants_carts WHERE cartId = ?");
            $stmt->bindParam(1, $cartId, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } catch (PDOException $e) {
            echo "Database Error : " . $e->getMessage();
            exit;
        }
    }

    public function addToCart(Cart $cart)
    {
        $cartId = $cart->getCartId();
        $plantId = $cart->getPlant()->getId();

        try {
            $stmt = $this->db->prepare("INSERT INTO plants_carts (cartId, plantId) VALUES (?,?)");
            $stmt->bindParam(1, $cartId, PDO::PARAM_INT);
            $stmt->bindParam(2, $plantId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Database Error : " . $e->getMessage();
            return false;
        }
    }

    public function incrementQuantity(Cart $cart)
    {
        $cartId = $cart->getCartId();
        $plantId = $cart->getPlant()->getId();
        $quantity = $cart->getQuantity();
        $quantity++;

        try {
            $stmt = $this->db->prepare("UPDATE plants_carts SET quantity = ? WHERE plantId = ? AND cartId = ?");
            $stmt->bindParam(1, $quantity, PDO::PARAM_INT);
            $stmt->bindParam(2, $plantId, PDO::PARAM_INT);
            $stmt->bindParam(3, $cartId, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } catch (PDOException $e) {
            echo "Database Error : " . $e->getMessage();
            return false;
        }
    }

    public function reduceQuantity(Cart $cart)
    {
        $cartId = $cart->getCartId();
        $plantId = $cart->getPlant()->getId();
        $quantity = $cart->getQuantity();
        $quantity--;

        try {
            $stmt = $this->db->prepare("UPDATE plants_carts SET quantity = ? WHERE plantId = ? AND cartId = ?");
            $stmt->bindParam(1, $quantity, PDO::PARAM_INT);
            $stmt->bindParam(2, $plantId, PDO::PARAM_INT);
            $stmt->bindParam(3, $cartId, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } catch (PDOException $e) {
            echo "Database Error : " . $e->getMessage();
            return false;
        }
    }

    public function PlantExistsInCart(Cart $cart)
    {
        $cartId = $cart->getCartId();
        $plantId = $cart->getPlant()->getId();

        try {
            $stmt = $this->db->prepare("SELECT * FROM plants_carts WHERE plantId = ? AND isCommanded = 0 AND cartId = ?");
            $stmt->bindParam(1, $plantId, PDO::PARAM_INT);
            $stmt->bindParam(2, $cartId, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->Cart = new Cart();
                    $this->Cart->setQuantity($row['quantity']);
                    $this->Cart->setIsSelected($row['isSelected']);
                }
                return $this->Cart;
            } else return NULL;
        } catch (PDOException $e) {
            echo "Database Error : " . $e->getMessage();
        }
    }

    public function toggleSelected(Cart $cart)
    {
        $cartId = $cart->getCartId();
        $plantId = $cart->getPlant()->getId();
        $isSelected = $cart->getIsSelected();

        if ($isSelected == 0) {
            $isSelected = 1;
        } else $isSelected = 0;

        $stmt = $this->db->prepare("UPDATE plants_carts SET isSelected = ? WHERE cartId = ? AND plantId = ?");
        $stmt->bindParam(1, $isSelected, PDO::PARAM_INT);
        $stmt->bindParam(2, $cartId, PDO::PARAM_INT);
        $stmt->bindParam(3, $plantId, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function updateCheckedItems(Cart $cart)
    {
        $cartId = $cart->getId();
        $isSelected = $cart->getIsSelected();
        $isCommanded = $cart->getIsCommanded();

        $stmt = $this->db->prepare("UPDATE plants_carts SET isCommanded = ? WHERE cartId = ? AND isSelected = ? AND isCommanded = 0");
        $stmt->bindParam(1, $isCommanded, PDO::PARAM_INT);
        $stmt->bindParam(2, $cartId, PDO::PARAM_INT);
        $stmt->bindParam(3, $isSelected, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
