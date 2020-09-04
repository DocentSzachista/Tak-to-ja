<?php
require_once 'dBConnect.inc.php';
/*
Czemu klasa? Bo można zamknąć łatwo jak funkcję wykonywanie części kodu ale też od razu z zapisanymi danymi, 
więc nie ma od chuja powtórzeń po 30 linijek.

Tworzenie obiektu na przykład student:
$użytkownik = new student("SELECT* FROM sbe_students WHERE id =?", $id, $userType)
Korzystanie z metod
$użytkownik->"Twojametoda";
*/

abstract class AbstractUser
{
    protected $data;
    protected $permission;
    abstract protected function returnData(string $str);
    //abstract protected function updateData(string $str);
    protected function permission()
    {
        return $this->permission;
    }
}

?>