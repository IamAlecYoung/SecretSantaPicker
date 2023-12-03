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
</head>

<body class="d-flex flex-column h-100">
    <div class="container">
    
        <h1 class="display-4"> 
            <i><img src="./pics/emoji/santa.svg" height="64" alt="Mr Santa icon"/></i>
            <i><img src="./pics/emoji/present.svg" height="64" alt="Present icon"/></i>
            <i><img src="./pics/emoji/tree.svg" height="64" alt="Tree icon"/></i>
            Seshmas at <strike>the Burns</strike> home 
            (<i><img src="./pics/emoji/cry.svg" height="64" alt="Cry icon"/></i>)
        </h1>

        <div class="jumbotron pt-4">
            <h2 class="display-4 align-left">
                <i><img src="./pics/emoji/thinking.svg" height="64" alt="thinking icon"/></i>
                <span class="spinwheeltext">Spin the Wheel</span>
            </h2>
            <p class="lead">Decided to make it a bit different this year. Instead of being given someone, you now need to SPIN THE WHEEEL!!!!</p>
            <hr class="my-4">
            <div class="row">

                <div class="col-6 offset-3 text-center">
                    <div class="roulette_container mb-1" >
                        <div class="roulette" style="display:none;">
                            <?php 

                            $WhosPicking = $_SESSION["ID"];

                            $getMaPeeps = $conn->prepare("SELECT * FROM `peeps` WHERE `ID` != :whoPicked and `year` = (select currentyear from settings)" );
                            $getMaPeeps->bindParam(":whoPicked", $WhosPicking);
                            $getMaPeeps->execute();

                            foreach ($getMaPeeps->fetchAll() as $row) {
                            echo '
                            <img src="pics/'.$row['pic'].'" alt="'.$row['name'].' Picture" title="'.$row['name'].'" class="img-fluid mx-auto d-block">
                            ';
                        }

                        ?>
                        </div>
                    </div>
                    <div id="soundElement">
                        <audio id="roulettewheelsound">
                            <source src="sound/wheel_fortune_1.mp3" type="audio/mp3">
                        </audio>
                    </div>

                    <h2 class="d-inline-block">
                        <button class="btn btn-success start">
                            <i><img src="./pics/emoji/hope.svg" height="30" alt="hope icon"/></i>
                            Spin
                        </button>
                        <button class="btn btn-success stop" style="display:none" disabled> 
                            <i><img src="./pics/emoji/omg.svg" height="30" alt="OMG icon"/></i>
                            Spinning...
                        </button>

                    </h2>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/roulette.js"></script>
    <?php
        $WhosPicking = $_SESSION["ID"];

        // Same as above, just need to find pic number
        $getMaPeeps = $conn->prepare("SELECT * FROM `peeps` WHERE `ID` != :whoPicked and `year` = (select currentyear from settings)");
        $getMaPeeps->bindParam(":whoPicked", $WhosPicking);
        $getMaPeeps->execute();

        //See who the user picked
        $getRecipient = $conn->prepare("SELECT * from `peeps` WHERE `ID` = (SELECT Person2 FROM whopickedwho WHERE Person1 = :whoPicked)");
            $getRecipient->bindParam(":whoPicked", $WhosPicking);
            $getRecipient->execute();

        $row = $getRecipient->fetch();

        $selectedPeepNumber = 0;
        foreach ($getMaPeeps->fetchAll() as $findPeepPosition) {
            if($findPeepPosition['ID'] == $row['ID'])
            {
                break;
            }
            $selectedPeepNumber++;
        }

        echo '
            <script>
                var sfx = document.getElementById("roulettewheelsound");

                var option = {
                    speed : 15,
                    duration : 1,
                    stopImageNumber :'. $selectedPeepNumber .',
                    startCallback : function() {
                        sfx.play();
                    },
                    slowDownCallback : function() {
                        //console.log(\'slowDown\');
                    },
                    stopCallback : function($stopElm) {
                        sfx.pause();
                        setTimeout(() => {
                            window.location = "whoyougot.php"
                        }, 1000);
                    }
                }
                var rouletter = $(\'div.roulette\').roulette(option);
                
                $(\'.start\').click(function(){
                    rouletter.roulette(\'start\');
                    $(\'.start\').hide();
                    $(\'spinwheeltext\').val = "Spinning...";
                    $(\'.stop\').show();	
                });
            </script>
        ';
    ?>
</body>