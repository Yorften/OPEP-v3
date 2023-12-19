<?php
require_once 'Plant.php';
class Cart
{

    private $Id;
    private $Plant_CartId;
    private Plant $Plant;
    private $Quantity;
    private $isSelected;
    private $isCommanded;

    public function __construct()
    {
        $this->Plant = new Plant();
    }



    /**
     * Get the value of Plant
     */
    public function getPlant()
    {
        return $this->Plant;
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
     * Get the value of Quantity
     */
    public function getQuantity()
    {
        return $this->Quantity;
    }

    /**
     * Set the value of Quantity
     *
     * @return  self
     */
    public function setQuantity($Quantity)
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    /**
     * Get the value of isSelected
     */
    public function getIsSelected()
    {
        return $this->isSelected;
    }

    /**
     * Set the value of isSelected
     *
     * @return  self
     */
    public function setIsSelected($isSelected)
    {
        $this->isSelected = $isSelected;

        return $this;
    }

    /**
     * Get the value of isCommanded
     */
    public function getIsCommanded()
    {
        return $this->isCommanded;
    }

    /**
     * Set the value of isCommanded
     *
     * @return  self
     */
    public function setIsCommanded($isCommanded)
    {
        $this->isCommanded = $isCommanded;

        return $this;
    }

    /**
     * Get the value of Plant_CartId
     */
    public function getPlant_CartId()
    {
        return $this->Plant_CartId;
    }

    /**
     * Set the value of Plant_CartId
     *
     * @return  self
     */
    public function setPlant_CartId($Plant_CartId)
    {
        $this->Plant_CartId = $Plant_CartId;

        return $this;
    }
}
