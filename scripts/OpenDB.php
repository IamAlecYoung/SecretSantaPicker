<?php

//$directory = "/Seshmas/";
$directory = "/projects/Seshmas/";

$servername = "-------";
$username = "---------";
$password = "---------";
$dbname = "-----------";


    //Initialise the PDO connection
    $conn = new PDO('mysql:host='.$servername.';dbname='.$dbname,$username,$password);

    //Testing purposes error mode on
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
