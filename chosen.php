<?php
REQUIRE 'scripts/OpenDB.php';
session_start();
?>

<head>
    <title>Pick yo self - Merry Seshmas</title>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="d-flex flex-column h-100">

    <?php
        // Simple sanity checks
        $totalPeeps = $conn->prepare("SELECT COUNT(name) FROM `peeps`");
        $totalPeeps->execute();
        $row = $totalPeeps->fetch();
        if(!isset($_GET['ID'])){
            $_SESSION['error'] = "Fuck Sake Vince! (No one selected)";
            header('Location: '.$directory.'index.php');
        }
        if($_GET['ID'] > $row[0]){
            $_SESSION['error'] = "Fuck Sake Vince! (That many folk arent taking part)";
            header('Location: index.php');
        }
    ?>

    <div class="container">
        <h1 class="display-4"> 
            <i><img src="./pics/emoji/santa.svg" height="64" alt="Mr Santa icon"/></i>
            <i><img src="./pics/emoji/present.svg" height="64" alt="Present icon"/></i>
            <i><img src="./pics/emoji/tree.svg" height="64" alt="Tree icon"/></i>
            Seshmas at <strike>the Clansman</strike> home 
            (<i><img src="./pics/emoji/cry.svg" height="64" alt="Cry icon"/></i>)
        </h1>

        <div class="jumbotron pt-4">

            <?php
                //Query the Database
                $getMaPeeps = $conn->prepare("SELECT * FROM `peeps` WHERE `ID` = :id");
                    $getMaPeeps->bindParam(":id", $_GET['ID']);
                    $getMaPeeps->execute();

                foreach ($getMaPeeps->fetchAll() as $row) {

                    echo '

                    <div class="row">
                        <div class="col-6 offset-3">
                        <div class="justify-content-between">
                            <h2 class="display-4 d-inline-block">
                                <i><img src="./pics/emoji/grinning.svg" height="64" alt="Grinning icon"/></i>
                                '.$row['name'].'
                            </h2>
                            <a style="display: inline-block;" class="small" href="index.php">
                                <p>WTF, That\'s not me?! <i><img src="./pics/emoji/thinking.svg" height="30" alt="Thinking icon"/></i></p>
                            </a>
                        </div>

                        <img src="pics/'.$row['pic'].'" alt="'.$row['name'].' Picture" title="'.$row['name'].'" class="img-fluid mx-auto d-block">
                    
                        <form method="post" action="scripts/verify.php">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input name="pass" type="text" class="form-control form-control-lg" id="password">
                            </div>
                            <input name="user" type="hidden" value="'.$row['ID'].'">
                            <input type="submit" class="btn btn-success">
                        </form>
                        
                        </div>
                    </div>';

                    if(isset($_SESSION['error'])){   
                        echo '<div class="alert alert-danger mt-2 mb-2" role="alert">
                        <h4 class="alert-heading">
                          <i><img src="./pics/emoji/exclamation.svg" height="64" alt="Exclamation icon"/></i>
                          <i><img src="./pics/emoji/siren.svg" height="64" alt="Siren icon"/></i>
                          Something wasn\'t right.
                        </h4>
                            <hr>
                            <i></i>
                            <p>'.$_SESSION['error'].'</p>
                        </div>'; 
                      session_unset('error');
                      }


                }
            ?>
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