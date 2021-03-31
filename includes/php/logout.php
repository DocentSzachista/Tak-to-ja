<?php
session_start();
$userType=$_SESSION['userType'];
session_unset();
session_destroy();
if($userType=="teacher")
{
    header("Location: ./../../sbe-teacher/index.php?account=loggedout");
}
else
{
    header("Location: ./../../index.php?account=loggedout");
}
?>

