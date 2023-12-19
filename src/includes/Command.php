<?php
require_once 'Cart.php';

class Command
{
    private $Id;
    private $Date;
    private $Total;
    private Cart $Cart;

    public function __construct()
    {
        $this->Cart = new Cart();
    }

    /**
     * Get the value of Id
     */ 
    public function getId()
    {
        return $this->Id;
    }

    /**
     * Set the value of Id
     *
     * @return  self
     */ 
    public function setId($Id)
    {
        $this->Id = $Id;

        return $this;
    }

    /**
     * Get the value of Date
     */ 
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * Set the value of Date
     *
     * @return  self
     */ 
    public function setDate($Date)
    {
        $this->Date = $Date;

        return $this;
    }

    /**
     * Get the value of Total
     */ 
    public function getTotal()
    {
        return $this->Total;
    }

    /**
     * Set the value of Total
     *
     * @return  self
     */ 
    public function setTotal($Total)
    {
        $this->Total = $Total;

        return $this;
    }

    /**
     * Get the value of Cart
     */ 
    public function getCart()
    {
        return $this->Cart;
    }

    /**
     * Set the value of Cart
     *
     * @return  self
     */ 
    public function setCart($Cart)
    {
        $this->Cart = $Cart;

        return $this;
    }
}
