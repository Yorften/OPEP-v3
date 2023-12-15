<?php
require_once('conn.php');

class Users extends Connection
{
    public $userId;
    public $userName;
    public $userEmail;
    public $userPassword;
    public $isVerified;
    public $roleId;
}

class Register extends Connection
{
    public $userId;
    public function register($username, $email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE userName = ? OR userEmail = ?;");
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $result = false;
            } else {
                $stmt = $this->conn->prepare("INSERT INTO users (userName,userEmail,userPassword) VALUES (?,?,?)");
                $stmt->bindParam(1, $username);
                $stmt->bindParam(2, $email);
                $stmt->bindParam(3, $password);
                $stmt->execute();
                $this->userId = $this->conn->lastInsertId();
                $result = true;
            }
        } catch (PDOException $e) {
            $result = false;
            echo "Database Error: " . $e->getMessage();
        }
        return $result;
    }
}

class Login extends Connection
{
    public function login($email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE userEmail = ?;");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
            } else $result = false;
        } catch (PDOException $e) {
            $result = false;
            echo "Database Error: " . $e->getMessage();
        }
        return $result;
    }
}
