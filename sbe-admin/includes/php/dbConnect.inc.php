<?php
//łączenie się z bażą (ile to już można xD)
function dbConnect($dBName)
{
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    //$dBName="baza_uczeszczajacych";

    $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
    if ($conn) {
        return $conn;
    } else {
        die("Connection failed:" . mysqli_connect_error());
    }
}
