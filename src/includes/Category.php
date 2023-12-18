<?php

class Category
{
    private $Id;
    private $Name;

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
    public function setName($name)
    {
        $this->Name = $name;
    }
    public function setId($id)
    {
        $this->Id = $id;
    }
}
