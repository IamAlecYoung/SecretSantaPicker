<?php
REQUIRE 'OpenDB.php';
    session_start();

$WhosPicking = $_POST['user'];
$formConstent = $_POST['consented'];

if($formConstent == "Yes")
{
    $formAddre1 = $_POST['address1'];
    $formAddre2 = $_POST['address2'];
    $formAddre3 = $_POST['address3'];
    $formPostco = $_POST['postcode'];
    $formExtras = $_POST['extra'];
    $formCreepy = $_POST['creepy'];

    // Update persons address deets 
    //---------------------------
        $picker = $conn->prepare("UPDATE `Peeps` 
                                  SET `address1` = :address1,
                                      `address2` = :address2,
                                      `address3` = :address3,
                                      `postcode` = :postcode,
                                      `extra` = :extra,
                                      `creepy` = :creepy,
                                      `consent` = :consent
                                      WHERE `ID` = :id");
        $picker->bindParam(":id", $WhosPicking);
        $picker->bindParam(":address1", $formAddre1);
        $picker->bindParam(":address2", $formAddre2);
        $picker->bindParam(":address3", $formAddre3);
        $picker->bindParam(":postcode", $formPostco);
        $picker->bindParam(":extra", $formExtras);
        $picker->bindParam(":creepy", $formCreepy);
        $picker->bindParam(":consent", $formConstent);

        $picker->execute();
}
else
{
    $picker = $conn->prepare("UPDATE `Peeps` SET `consent` = :consent WHERE `ID` = :id");
        $picker->bindParam(":id", $WhosPicking);
        $picker->bindParam(":consent", $formConstent);
        $picker->execute();
}

    $_SESSION["ID"] = $WhosPicking;
    
    header("Location: ../spinthewheel.php");

?>