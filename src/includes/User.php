<?php
class User
{

    private $Id;
    private $Name;
    private $Email;
    private $isVerified;
    private $Role;

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
    public function getEmail()
    {
        return $this->Email;
    }
    public function getIsVerified()
    {
        return $this->isVerified;
    }
    public function getRole()
    {
        return $this->Role;
    }



    // Setters --------------------------------

    public function setId($id)
    {
        $this->Id = $id;
    }
    public function setName($name)
    {
        $this->Name = $name;
    }
    public function setEmail($email)
    {
        $this->Email = $email;
    }
    public function setIsVerified($verified)
    {
        $this->isVerified = $verified;
    }
    public function setRole($role)
    {
        $this->Role = $role;
    }
}
