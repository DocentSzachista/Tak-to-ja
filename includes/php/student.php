<?php
require_once "dBConnect.inc.php";
require_once "AbstractUser.php";
/*
Instrukcja obsługi dostępna w komentarzu abstract User

*/
class student extends AbstractUser
{
    private $pdo;
    function __construct($sql, $id, $permission)
    {
        $this->pdo=Database::connect();
        $this->data=$this->downloadData($sql, $id);
        $this->permission=$permission;
    }
    private function downloadData($sql, $id)
    {
        
        $query=$this->pdo->prepare($sql);
        $query->execute(array($id));
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function returnData($str)
    {
        return $this->data[$str];
    }
    
}
