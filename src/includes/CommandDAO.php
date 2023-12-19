<?php

require_once 'conn.php';
require_once 'Command.php';

class CommandDAO
{
    private $db;
    private Command $Command;

    public function __construct()
    {
        $this->db = Connection::getInstance()->getConnection();
        $this->Command = new Command();
    }

    /**
     * Get the value of Command
     */
    public function getCommand()
    {
        return $this->Command;
    }

    public function checkoutItems(Command $command){
        $date = $command->getDate();
        $total = $command->getTotal();
        $cartId = $command->getCart()->getId();
 
        $stmt = $this->db->prepare("INSERT INTO commands (commandDate,cartId,total) VALUES (?,?,?)");
        $stmt->bindParam(1,$date,PDO::PARAM_STR);
        $stmt->bindParam(2,$cartId,PDO::PARAM_INT);
        $stmt->bindParam(3,$total,PDO::PARAM_INT);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}
