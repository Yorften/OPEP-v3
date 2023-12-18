<?php

class Plant
{
    private $Id;
    private $Name;
    private $Desc;
    private $Image;
    private $Price;
    private $Category;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->Id;
    }
    public function getName()
    {
        return $this->Name;
    }
    public function getDesc()
    {
        return $this->Desc;
    }
    public function getImage()
    {
        return $this->Image;
    }
    public function getPrice()
    {
        return $this->Price;
    }
    public function getCategory()
    {
        return $this->Category;
    }
    

    public function setId($id)
    {
        $this->Id = $id;
    }
    public function setName($name)
    {
        $this->Name = $name;
    }
    public function setDesc($desc)
    {
        $this->Desc = $desc;
    }
    public function setImage($image)
    {
        $this->Image = $image;
    }
    public function setPrice($price)
    {
        $this->Price = $price;
    }
    public function setCategory($category)
    {
        $this->Category = $category;
    }
  
}
