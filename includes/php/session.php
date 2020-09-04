<?php
if(isset($_SESSION['userId']) )
{
    if($_SESSION['userType']=="admin")
    {
        header("Location: sbe-admin\includes\php\main.php");
        exit();
    }
    if( time()-$_SESSION['time']<5*60)
    {
    $_SESSION['time']=time();
    }
    else{
        session_unset();
        session_destroy();
        header("Location: index.php?error=sessionexpired");
        exit();
    }
}
else
{
    header("Location: index.php");
    exit();
}
