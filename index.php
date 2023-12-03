<?php
REQUIRE 'scripts/OpenDB.php';
session_start();
?>


<head>
<title>Merry Seshmas</title>
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
    Seshmas at <strike>the Burns</strike> home
    (<i><img src="./pics/emoji/cry.svg" height="64" alt="Cry icon"/></i>)
  </h1>
  <?php

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
  
  ?>

  <div class="jumbotron pt-4">
      <h2 class="display-4 align-left">
      <i><img src="./pics/emoji/grinning.svg" height="64" alt="Grinning icon"/></i>
       Still to pick someone 
      </h2>
      <p class="lead">If you still need to pick someone, click your picture below</p>
      <hr class="my-4">
      <div class="row">
          <?php
          // Peeps who have yet to pick
            $queryDB = $conn->query('SELECT * FROM `peeps` WHERE `picking` = 0 and `year` = (select currentyear from settings) order by rand()');
              
                //Echo out each individual row
              foreach ($queryDB->fetchAll() as $row) {
                echo '
                <div class="col-sm-6 col-md-4 col-lg-2">
                  <a href="chosen.php?ID='.$row['ID'].'">
                    <img src="pics/'.$row['pic'].'" alt="'.$row['name'].' Picture" title="'.$row['name'].'" class="img-fluid">
                  </a>
                </div>';
              }
          ?>
        </div>
  </div>


  <div class="jumbotron pt-4">
      <h2 class="display-4 align-left">
      <i><img src="./pics/emoji/looky.svg" height="64" alt="Eyes icon"/></i>
      Cant remember who you picked? 
      </h2>
      <p class="lead">If you still need a wee reminder, click your picture below</p>
      <hr class="my-4">
      <div class="row">
        <?php
        // Peeps who have already picked.
              $queryDBTwo = $conn->query('SELECT * FROM `peeps` WHERE `picking` = 1 and `year` = (select currentyear from settings) order by rand()');
            //Echo out each individual row
            foreach ($queryDBTwo->fetchAll() as $row) {

              echo '
              <div class="col-sm-6 col-md-4 col-lg-2">
              <a href="chosen.php?ID='.$row['ID'].'">
              <img src="pics/'.$row['pic'].'" alt="'.$row['name'].' Picture" title="'.$row['name'].'" class="img-fluid">
              </a>
              </div>';
            }
        ?>
      </div>
  </div>


  <style type="text/css">
  /* h1, h2 { text-align: center; font-family: sans-serif; } */
  img { opacity: 0.6; transition: transform 1s, opacity 0.5s;}
  /* width: 200px; */
  img:hover {transform: rotate(10deg); opacity: 1;}
  /* html { max-width: 1250px; margin: 0 auto;} */
      .errorMessage {
          font-family: sans-serif;
          background-color: red;
          padding: 1px 5px; 
          font-size: 1em;
          margin: 20px;
          text-align: center;
      }

  </style>
  
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

