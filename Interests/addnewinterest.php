<?php
REQUIRE '../scripts/OpenDB.php';
session_start();

if(!isset($_SESSION['ID'])){
  $_SESSION["error"] = "Not Logged in.";
  header("Location: ../index.php");
  echo '<a href="/projects/Seshmas">sdfsd</a>';
}

?>

<head>
<title>Add Info - Merry Seshmas</title>
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>


    <?php
        // Simple sanity checks
        if(!isset($_GET['ID'])){
            $_SESSION['error'] = "Fuck Sake Vince! (No one selected)";
            header('Location: '.$directory.'index.php');
        }
    ?>

    <div class="container">
    
        <h1 class="display-4"> 
            <i><img src="../pics/emoji/santa.svg" height="64" alt="Mr Santa icon"/></i>
            <i><img src="../pics/emoji/present.svg" height="64" alt="Present icon"/></i>
            <i><img src="../pics/emoji/tree.svg" height="64" alt="Tree icon"/></i>
            Seshmas at <strike>the Burns</strike> home 
            (<i><img src="../pics/emoji/cry.svg" height="64" alt="Cry icon"/></i>)
        </h1>

        <a style="display: inline-block;" class="small" href="../index.php">
            <p> &lt; Home</p>
        </a>

        <div class="jumbotron pt-4">
            <h2 class="display-4 align-left">
                <i><img src="../pics/emoji/thinking.svg" height="64" alt="thinking icon"/></i>
                Add Info For
            </h2>
            <hr class="my-4">
            
                <?php
                
                    $WhosPicking = $_SESSION["ID"];
                    $WhosPicked = $_GET['ID'];

                    //Query the Database
                    $getMaPeeps = $conn->prepare("SELECT * FROM `peeps` WHERE `ID` = :id");
                    $getMaPeeps->bindParam(":id", $WhosPicked);
                    $getMaPeeps->execute();

                    foreach ($getMaPeeps->fetchAll() as $row) {

                        echo '

                        <div class="row">
                            <div class="col-6 offset-3">
                            <div class="justify-content-between">
                                <h2 class="display-4 d-inline-block">
                                    <i><img src="../pics/emoji/grinning.svg" height="64" alt="Grinning icon"/></i>
                                    '.$row['name'].'
                                </h2>
                                <a style="display: inline-block;" class="small" href="index.php">
                                    <p>Select Again? <i><img src="../pics/emoji/thinking.svg" height="30" alt="Thinking icon"/></i></p>
                                </a>
                            </div>

                            <img src="../pics/'.$row['pic'].'" alt="'.$row['name'].' Picture" title="'.$row['name'].'" class="img-fluid mx-auto d-block">
                        
                            </div>
                        </div>';
                    }

                    
                ?>

                <hr>
                <br>
                <div class="whatNowBlock">
                    <h2 style="text-align: left;"> Ya Boiis interests? </h2>
                    <p> This year, I've added a quick wee thing where others can share a persons interests, just in case you've got someone you don't know very well </p>
                    
                    <?php
                
                        $WhosPicking = $_SESSION["ID"];
                        

                        // Add new interest form action
                        echo '
                            <form method="post" action="../scripts/newinterest_add.php">
                                <div class="input-group">
                                    <input name="interest" placeholder="Add new interest" type="text" class="form-control form-control-sm" id="interest">
                                    <button type="submit" class="btn btn-success btn-sm">Add New</button>
                                </div>
                                <input name="userAdding" type="hidden" value="'.$WhosPicking.'">
                                <input name="userFor" type="hidden" value="'.$_GET['ID'].'">
                            </form>
                        ';

                        //See who the user picked
                        $getPersonsInterests = $conn->prepare("SELECT * FROM `interests` WHERE PeepID = :whosPicked and AddedBy = :addedBy");
                            $getPersonsInterests->bindParam(":whosPicked", $_GET["ID"]);
                            $getPersonsInterests->bindParam(":addedBy", $WhosPicking);
                            $getPersonsInterests->execute();
                        
                        if($getPersonsInterests->rowCount() > 0){
                            echo '<ul>';
                            foreach ($getPersonsInterests->fetchAll() as $row) {
                                echo '<li>'.$row['Interest'].'</li>';
                            }
                            echo '</ul>';
                        }
                        else {
                            echo '<p><i><img src="../pics/emoji/cry.svg" height="24" alt="Cry icon"/></i> Looks like theres nothing here at this point, give it an hour/day or two and see if anyone adds some in.</p>';
                        }
                    
                    ?>
                
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