<?php
    function addUser($sqlINSERT, $sqlUserExist, $arrayOfInputs)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $q = $pdo->prepare($sqlUserExist);
        //$q->bindParam(':name', $login);
        $q->execute([$arrayOfInputs[1]]);

        if ($q->rowCount() > 0) {
            Database::disconnect();
            header("Location: ../../main.php?error=existuser");
        } else {            
            $q = $pdo->prepare($sqlINSERT);
            $q->execute($arrayOfInputs);//array($login, $email, $phone, $firstname, $lastname, $password, $team)
            Database::disconnect();   
        }
    }
    function delete($sql, $isCalendar)
    {
        $id = 0;
        if (!empty($_GET['id'])) 
        {
            if($isCalendar){
                $id = $_REQUEST['lesson_id'];
            } else {
                $id = $_REQUEST['id'];
            }
        }
        if (!empty($_POST)) 
        {
            // keep track post values
            if($isCalendar){
                $id = $_POST['lesson_id'];
            } else {
                $id = $_POST['id'];
            }
            // delete data
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            Database::disconnect();
            if($isCalendar){
                header("Refresh:0");
            } else {
                header("Location: ../../../../main.php");
            }
        }
    }
    /*
        Funkcja do wyszukiwania użytkownika: przyjmuje to co wpiszemy, potem komendę sql i jaką kolumnę chcemy zwrocic
    */
    function searchUser($itemGiven, $sql, $itemRetrieved)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $q = $pdo->prepare($sql);
        $q->execute(array($itemGiven));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
        return $data[$itemRetrieved];
    }
    /*
        Funkcja paginująca, przyjmuje na wejscie: tabelę po której ma następować paginacja, ilość rekordów na stronę, miejsce od któego zaczyna.
    */
    function pagin($page_query, $num_per_page, $start_from)
    {
        $pdo= Database::connect();
        $page_result = $pdo->query($page_query);
        $total_record = $page_result->fetchColumn();
        $total_pages = ceil($total_record / $num_per_page);
        return $total_pages;
    }
    /*
        Funkcja do wrzucania zmian w bazie danych 
    */
    function addFutureUser($sqlINSERT, $arrayOfInputs)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
            $q = $pdo->prepare($sqlINSERT);
            $q->execute($arrayOfInputs);
            Database::disconnect();
            return $pdo->lastInsertId();
    }
    function addTeam($sqlINSERT, $sqlUserExist, $arrayOfInputs)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$sql = "SELECT login FROM sbe_students WHERE login= :name ";
        $q = $pdo->prepare($sqlUserExist);
        //$q->bindParam(':name', $login);
        $q->execute([$arrayOfInputs[1]]);
        if ($q->rowCount() > 0) 
        {
            Database::disconnect();
            header("Location: ../../main.php?error=existuser");
        } 
        else 
        {          
            $q = $pdo->prepare($sqlINSERT);
            $q->execute($arrayOfInputs);
            Database::disconnect();
            return $pdo->lastInsertId();
        }
    }
function deleteUser($sql, $id)
{
    // delete data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$sql = "DELETE FROM sbe_students WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    Database::disconnect();
}
function getRowQuery($sql, $id)
{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$sql = "DELETE FROM sbe_students WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    //Database::disconnect();
    return $data;
}