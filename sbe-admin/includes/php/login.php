<?php
if (isset($_POST['login-submit'])) {
    require_once './crud/connectDB_CRUD.php';
    $mailuid =  $_POST['login'];
    $password = $_POST['password'];

    if (empty($mailuid) || empty($password)) {
        header("Location: ../../index.php?error=emptyfields");
        exit();
    } else {
        $pdo = Database::connect();
        $sql = checkIfMail($mailuid);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $pdo->prepare($sql);

        if (!$query) {
            header("Location: ../../index.php?error=wrongdatabase");
            exit();
        } else {
            $query->execute(array($mailuid));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                $pwdCheck = password_verify($password, $result['password']);
                if ($pwdCheck == false) {
                    header("Location: ../../index.php?error=wrongpwd");
                    exit();
                }
                //kreacja zmiennej sesji która będzie pamiętała, że jesteśmy zalogowani
                else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $result['id'];
                    $_SESSION['userName'] = $result['login'];
                    $_SESSION['time'] = time();
                    $_SESSION['userType'] = "admin";
                    header("Location: ../php/main.php?login=success");
                    exit();
                }
            } else {

                header("Location: ../../index.php?error=nouser");
                exit();
            }
        }
    }
} else {
    header("Location: ../../index.php");
    exit();
}
function checkIfMail($login)
{
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        return  "SELECT * FROM sbe_admins WHERE email=?;";
    } else if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $login)) {
        return "SELECT * FROM sbe_admins WHERE login=?";
    } else
        header("Location: ../../index.php?error=functionerror");
}
