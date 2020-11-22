<?php
REQUIRE 'OpenDB.php';
session_start();


if(!isset($_SESSION["ID"])){
    $_SESSION["error"] = "Not Logged in.";
    header("Location: ../index.php");
    echo '<a href="/projects/Seshmas">sdfsd</a>';
} else {
    $WhoPicked = $_SESSION["ID"];

    //Can they repick
    //---------------------
    $canIsayFuckThis = $conn->prepare("SELECT `WhatNo` FROM `peeps` WHERE `ID` =  :id");
        $canIsayFuckThis->bindParam(":id", $WhosPicking);
        $canIsayFuckThis->execute();
            $FuckThat = $canIsayFuckThis->fetch();

    if($FuckThat[0] == 0){ 


        //Find out who you picked
        //-----------------------
            $getWhoYouPicked = $conn->prepare("SELECT Person2 From `whopickedwho` WHERE Person1 = :person1");
            $getWhoYouPicked->bindParam(":person1", $WhoPicked);
            $getWhoYouPicked->execute();

                $row = $getWhoYouPicked->fetch();

        //Remove from Datbase (whoyoupickedtable)
        //--------------------------------------
            $RemoveRow = $conn->prepare("DELETE from `whopickedwho` WHERE `Person1` = :person1");
            $RemoveRow->bindParam(":person1", $WhoPicked);
                $RemoveRow->execute();

        //Set Person1 Pick status to zero
            $ChangeOne = $conn->prepare("UPDATE `peeps` SET `picking`=0 WHERE `ID` = :id");
            $ChangeOne->bindParam(":id", $WhoPicked);
                $ChangeOne->execute();

        //Set Person2 Pick statis tp zero
            $ChangeTwo = $conn->prepare("UPDATE `peeps` SET `picked`=0 WHERE `ID` = :id");
            $ChangeTwo->bindParam(":id", $row[0]);
                $ChangeTwo->execute();

        //Set users repick to 1
        //-----------------------
            $UpRepick = $conn->prepare("UPDATE `peeps` SET `WhatNo` = 1 WHERE `ID` = :id");
                $UpRepick->bindParam(":id", $WhoPicked);
                $UpRepick->execute();

            $_SESSION["error"] = "You can now choose again.";
            header("Location: ../chosen.php?ID=".$WhoPicked."");
            echo '<a href="/projects/Seshmas">sdfsd</a>';

    } else {
            $_SESSION["error"] = "You can only repick once.";
            header("Location: ../chosen.php?ID=".$WhoPicked."");
            echo '<a href="/projects/Seshmas">sdfsd</a>';
    }

}
    ?>