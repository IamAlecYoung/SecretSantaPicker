<?php
REQUIRE 'OpenDB.php';
session_start();

echo $_POST['userAdding'];
echo $_POST['userFor'];
echo $_POST['interest'];

$addNewInterest = $conn->prepare("INSERT INTO `interests` (`PeepID`, `Year`, `AddedBy`, `AddedOn`, `Interest`) VALUES (:personFor, (select currentyear from settings), :personBy, (select curdate()), :interest)");
    $addNewInterest->bindParam(":personBy", $_POST['userAdding']);
    $addNewInterest->bindParam(":personFor", $_POST['userFor']);
    $addNewInterest->bindParam(":interest", $_POST['interest']);
    $addNewInterest->execute();

header("Location: ../Interests/addnewinterest.php?ID=".$_POST['userFor']."");

?>
