<?php
if(isset($_SESSION['userId']))
{
    if($_SESSION['userType']!="admin")
    {
        header("Location: ../../../../index.php");
        exit();
    }
    if( time()-$_SESSION['time']<10*60)
    {
    $_SESSION['time']=time();
    }
    else{
        session_unset();
        session_destroy();
        header("Location: ../../index.php?error=sessionexpired");
    }
}
else
{
    header("Location: ../../index.php");
}
?>
