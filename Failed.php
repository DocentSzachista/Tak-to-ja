<?php
session_start();
if(isset($_SESSION['userId']) && isset($_SESSION['userName']))
{
    echo $_SESSION['userId'];
    echo $_SESSION['userName'];
}
else
{
    header("Location: ./index.php");
}
