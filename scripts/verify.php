<?php
REQUIRE 'OpenDB.php';
    session_start();

$WhosPicking = $_POST['user'];
$passWord = strtoupper($_POST['pass']);
$locationSet = false;

//Check if they know the password
//-------------------------------
$getPass = $conn->prepare("SELECT `uniquePass` FROM `peeps` WHERE `ID` = :id");
$getPass->bindParam(":id", $WhosPicking);
$getPass->execute();

    $verify = $getPass->fetch();
   

if($verify[0] != $passWord){

    $_SESSION["error"] = "Wrong passcode";
    header("Location: ../chosen.php?ID=".$WhosPicking."");
} else {

    //Check to see if they have picked anyone before
    //----------------------------------------------
        $checkPick = $conn->prepare("SELECT `picking` FROM `peeps` WHERE `ID` = :id");
        $checkPick->bindParam(":id", $WhosPicking);
        $checkPick->execute();

            $HavetheyPicked = $checkPick->fetch();

    //Check if they have picked before
    if($HavetheyPicked['picking'] == 1){

        $getRecipient = $conn->prepare("SELECT * from `peeps` WHERE `ID` = (SELECT Person2 FROM whopickedwho WHERE Person1 = :whoPicked)");
        $getRecipient->bindParam(":whoPicked", $WhosPicking);
        $getRecipient->execute();

            $whoDidTheyPick = $getRecipient->fetch();

        //echo "You picked ".$whoDidTheyPick['name'];

        header("Location: ../whoyougot.php");
        $locationSet = true;

    } else {

        //Find second person
            $luckyContestantTwo = $conn->prepare("SELECT * FROM `peeps` WHERE `picked`= 0 and `year` = (select `currentyear` from `settings`) and ID != :personID order by rand() limit 1");
            $luckyContestantTwo->bindParam(":personID", $WhosPicking);
            $luckyContestantTwo->execute();

            $Person2 = $luckyContestantTwo->fetch();

        //Person 1 has picked someone
        //---------------------------
            $picker = $conn->prepare("UPDATE `peeps` SET `picking` = 1 WHERE `ID` = :id");
            $picker->bindParam(":id", $WhosPicking);
            $picker->execute();

        //Person 2 Has been Picked
        //---------------------------
            $picked = $conn->prepare("UPDATE `peeps` SET `picked` = 1 WHERE `ID` = :id");
            $picked->bindParam(":id", $Person2["ID"]);
            $picked->execute();


        //Update table that shows who has picked who
        //------------------------------------------
            $tagaPair = $conn->prepare("INSERT INTO `whopickedwho`(`Person1`, `Person2`, `year`) VALUES (:person1,:person2, 2020)");
                $tagaPair->bindParam(":person1", $WhosPicking);
                $tagaPair->bindParam(":person2", $Person2["ID"]);
                $tagaPair->execute();

        echo "You have picked ".$Person2["name"];

    }
    //}

    $_SESSION["ID"] = $WhosPicking;
    
    echo "2";
    //header("Location: ../whoyougot.php");
    
    if($locationSet == false)
    {
        header("Location: ../giesyeraddress.php");
    }
}

?>