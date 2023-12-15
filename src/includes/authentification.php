<?php
require_once('conn.php');

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
    public $userId;
    public $userName;
    public $isVerified;
    public $roleId;
    public $cartId;

    public function login($email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE userEmail = ?;");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $userId = $row["userId"];
                $userName = $row["userName"];
                $password_db = $row["userPassword"];
                $roleId = $row["roleId"];
                $isVerified = $row["isVerified"];

                if (password_verify($password, $password_db)) {
                    $stmt = $this->conn->prepare("SELECT * FROM carts WHERE userId = ?;");
                    $stmt->bindParam(1, $userId);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $this->cartId = $row['cartId'];
                    }
                    $this->userId = $userId;
                    $this->userName = $userName;
                    $this->isVerified = $isVerified;
                    $this->roleId = $roleId;
                    $result = 200;
                } else {
                    $result = 403;
                }
            } else $result = 404;
        } catch (PDOException $e) {
            $result = false;
            echo "Database Error: " . $e->getMessage();
        }
        return $result;
    }
}

class Role extends Connection
{
    public $userId;
    public $userName;
    public $cartId;

    public function setRole($userId, $userName, $choice)
    {
        if ($choice === "client") {
            try {
                $stmt = $this->conn->prepare("UPDATE users SET roleId = 1 WHERE userId = ?");
                $stmt->bindParam(1, $userId);
                $stmt->execute();
                $stmt = $this->conn->prepare("INSERT INTO carts (userId) VALUES (?)");
                $stmt->bindParam(1, $userId);
                $stmt->execute();
                $this->cartId = $this->conn->lastInsertId();
                $this->userId = $userId;
                $this->userName = $userName;
                $result = 201;
            } catch (PDOException $e) {
                echo "Database Error: " . $e->getMessage();
            }
        } else {
            try {
                $stmt = $this->conn->prepare("UPDATE users SET roleId = 2, isVerified = 0 WHERE userId = ?");
                $stmt->bindParam(1, $userId);
                $stmt->execute();
                $result = 202;
            } catch (PDOException $e) {
                echo "Database Error: " . $e->getMessage();
            }
        }
        return $result;
    }
}
