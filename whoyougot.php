<?php
REQUIRE 'scripts/OpenDB.php';
session_start();

if(!isset($_SESSION['ID'])){
    $_SESSION["error"] = "Not Logged in.";
    header("Location: index.php");
    echo '<a href="/projects/Seshmas">sdfsd</a>';
}

?>

<head>
<title>You got - Merry Seshmas</title>
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
        <h1 class="display-4"> 
            <i><img src="./pics/emoji/santa.svg" height="64" alt="Mr Santa icon"/></i>
            <i><img src="./pics/emoji/present.svg" height="64" alt="Present icon"/></i>
            <i><img src="./pics/emoji/tree.svg" height="64" alt="Tree icon"/></i>
            Seshmas at <strike>the Clansman</strike> home 
            (<i><img src="./pics/emoji/cry.svg" height="64" alt="Cry icon"/></i>)
        </h1>

        <div class="jumbotron pt-4">
            <h2 class="display-4 align-left">
            <i><img src="./pics/emoji/thinking.svg" height="64" alt="thinking icon"/></i>
            Who You got
            </h2>
            <hr class="my-4">
            

                <?php
                
                $WhosPicking = $_SESSION["ID"];

                //Can the user repick
                //---------------------
                $canIsayFuckThis = $conn->prepare("SELECT `WhatNo` FROM `peeps` WHERE `ID` =  :id");
                    $canIsayFuckThis->bindParam(":id", $WhosPicking);
                    $canIsayFuckThis->execute();
                        $FuckThat = $canIsayFuckThis->fetch();

                //See who the user picked
                $getRecipient = $conn->prepare("SELECT * from `peeps` WHERE `ID` = (SELECT Person2 FROM whopickedwho WHERE Person1 = :whoPicked)");
                        $getRecipient->bindParam(":whoPicked", $WhosPicking);
                        $getRecipient->execute();

                $row = $getRecipient->fetch();
                
                echo '
                <div class="row">
                <div class="col-6 offset-3 text-center">
                        <img src="pics/'.$row['pic'].'" alt="'.$row['name'].' Picture" title="'.$row['name'].'" class="img-fluid mx-auto d-block">
                        <h2 class="d-inline-block">
                            <i><img src="./pics/emoji/omg.svg" height="64" alt="OMG icon"/></i>
                            '.$row['name'].'
                        </h2>
                    </div>
                </div>
                ';

                echo '
                    <hr>
                    <div class="d-flex justify-content-between">';
                    
                     if($FuckThat[0] == 0){
                         echo '
                         <p><a href="scripts/repick.php" class="btn btn-danger">
                         <i><img src="./pics/emoji/nah.svg" height="30" alt="Nah icon"/></i>
                         Fuck that...
                         <br><span class="small">(Pick again)</span>
                         </a></p>
                         '; 
                        }
                        
                echo '     
                    <p><a href="spinthewheel.php" class="btn btn-success">
                    <i><img src="./pics/emoji/omg.svg" height="30" alt="omg icon"/></i>
                    I just wanna see the spinny wheel again 
                    <br><span class="small">(wont change result)</span>
                    </a></p>
                    </div>'; 
                ?>

                <hr>
                <br>
                <div class="whatNowBlock">
                <h2 style="text-align: left;"> What now? </h2>
                <p> That's it, end of the rabbit hole, that's all Alice found through the looking glass... </p>
                <p> I don't know any price limit, I just wanted to fuck about making this little thing to make Secret Santa easier to pick.</p>
                <p> Price limit is normally around &#163;5 - &#163;10 but spend as much or as little as you want</p>
                <br>
                <p> Oh, and to the person that got me. I swear it isn't rigged... but just incase, here's my <a href="http://y2u.be/dQw4w9WgXcQ" taget="_blank">Amazon Wishlist</a> Hint hint</p>
                </div>
            </div>
        </div>
    
    </div>

    <footer class="footer mt-auto py-3">
        <div class="container">
            <div class="d-flex justify-content-between">
                <span class="text-muted">Seshmas site</span>
                <span class="text-muted">
                    <a href="usage.php">Usage</a>
                </span>
            </div>
        </div>
    </footer>

    <!-- Google Analytics -->
    <script src="js/analytics.js"></script>
</body>
</html>