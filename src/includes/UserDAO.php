<?php

require_once 'conn.php';
require_once 'User.php';
class UserDAO
{
    private $db;
    private User $User;

    public function __construct()
    {
        $this->db = Connection::getInstance()->getConnection();
        $this->User = new User();
    }

    public function getObject()
    {
        return $this->User;
    }

    public function getClientsPage($start, $rows_per_page)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE roleId = 1 LIMIT ?,?");
        $stmt->bindParam(1, $start, PDO::PARAM_INT);
        $stmt->bindParam(2, $rows_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $Users = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->User = new User();
            $this->User->setId($row['userId']);
            $this->User->setName($row['userName']);
            $this->User->setEmail($row['userEmail']);
            $this->User->setIsVerified($row['isVerified']);
            $this->User->setRole($row['roleId']);
            array_push($Users, $this->User);
        }
        return $Users;
    }

    public function getModsPage($start, $rows_per_page)
    {

        $stmt = $this->db->prepare("SELECT * FROM users WHERE roleId = 2 LIMIT ?,?");
        $stmt->bindParam(1, $start, PDO::PARAM_INT);
        $stmt->bindParam(2, $rows_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $Users = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->User = new User();
            $this->User->setId($row['userId']);
            $this->User->setName($row['userName']);
            $this->User->setEmail($row['userEmail']);
            $this->User->setIsVerified($row['isVerified']);
            array_push($Users, $this->User);
        }
        return $Users;
    }

    public function toggleAccount(User $user)
    {
        $userId = $user->getId();
        $isVerified = $user->getIsVerified();
        if ($isVerified == 0) {
            $isVerified = 1;
        } else $isVerified = 0;
        try {
            $stmt = $this->db->prepare("UPDATE users SET isVerified = ? WHERE userId = ? ");
            $stmt->bindParam(1, $isVerified, PDO::PARAM_INT);
            $stmt->bindParam(2, $userId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Database Error : " . $e->getMessage();
            return false;
        }
    }
}
