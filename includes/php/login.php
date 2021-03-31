<?php
echo $userType;
if (isset($_POST['login-submit'])) {
    require_once 'dbConnect.inc.php';
    $userType = $_POST['login-submit'];
    if ($userType == "student") {
        $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
        $password = $_POST['password-stud'];
    } else if ($userType == "parent") {
        $login = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password-par'];
    } else if ($userType == "teacher") {
        $login = $_POST['login'];
        $password = $_POST['password-teach'];
    }

    if ((empty($login)) || empty($password)) {
        header("Location: ./../../index.php?error=emptyfields");
        exit();
    } else {
        if ($userType == "parent") {
            $sql = "SELECT * FROM sbe_parents WHERE email=?;";
        } else if ($userType == "student") {
            $sql = "SELECT * FROM sbe_students WHERE login=?;";
        } else if ($userType == "teacher") {
            $sql = "SELECT * FROM sbe_teachers WHERE login=?;";
        } else {
            header("Location: ./../../index.php?error=notemail");
            exit();
        }
        $pdo = Database::connect();
        $query = $pdo->prepare($sql);
        if (!$query) {
            header("Location: ./../../index.php?error=wrongdatabase");
            exit();
        } else {

            $query->execute(array($login));
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                $pwdCheck = password_verify($password, $result['password']);
                if ($pwdCheck == false) {
                    if($userType=="teacher")
                    {
                        header("Location: ./../../sbe_teacher.php?error=wrongpwd");
                    }
                    else
                    {
                        header("Location: ./../../index.php?error=wrongpwd");
                    }
                    exit();
                } else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $result['id'];
                    $_SESSION['time'] = time();
                    $_SESSION['userType'] = $userType;
                    header("Location: ../../main.php");

                    exit();
                }
            } else {
                if($userType=="teacher")
                {
                    header("Location: ./../../sbe_teacher.php?error=nouser");
                }
                else
                {
                    header("Location: ./../../index.php?error=nouser");
                }
                exit();
            }
        }
    }
} else {

    header("Location: ../../index.php");
    exit();
}
