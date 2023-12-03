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
<title>Address - Merry Seshmas</title>
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

        <div class="jumbotron pt-4">
            <h2 class="display-4 align-left">
            <i><img src="./pics/emoji/thinking.svg" height="64" alt="thinking icon"/></i>
            Gonnae gie's yer address
            </h2>
            <p class="lead">I know what you're thinking, What's that Creepy Bastard wanting ma address fur?</p>
            <hr class="my-4">
            
                <br>
                <div class="whatNowBlock">
                <h2 style="text-align: left;"> I know, I know. </h2>
                <p> Due to the situation this year, we're gonna have to play things different this year. </p>
                <p> Since we cannae be together in person (breaking a decade long tradition), we need to think ootside the boax </p>

                <p></p>
                <p>So here's my thinking.</p>
                <p>You try ship your presents to ME, I ship presents back to YOU! Fun times!</p>
                <p>So if you want to give me a suitable address below, I can arrange with Santa's little helpers to get you a happy Seshmas.</p>
                <p></p>
                <hr>
                <div class="row shadow-sm p-3 mb-5 bg-white rounded">
                    <div class="col-12">
                        <h2>Address time</h2>
                        <p>Don't worry, despite outward appearances, I do take Data Protection seriously, addresses are stored responsibly and will be deleted after Xmas is done</p>
                        <hr>
                    </div>
                    <div class="col-9">                    
                        <p><strong>Your Address</strong></p>
                        <form method="post" action="scripts/saveaddress.php">
                            <div class="form-group">
                                <label for="address1">Address line 1 (inc door number)</label>
                                <input type="text" name="address1" id="address1" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="address2">Address line 2</label>
                                <input type="text" name="address2" id="address2" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="address3">Address line 3</label>
                                <input type="text" name="address3" id="address3" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="postcode">Postcode</label>
                                <input type="text" name="postcode" id="postcode" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="extra">Anything I need to know (Flat buzzer combo, big dug, no in after 12)</label>
                                <input type="text" name="extra" id="extra" class="form-control">
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="creepy" id="creepy" class="custom-control-input" checked>
                                <label for="creepy" class="custom-control-label">I'd like random visits throughout the year</label>
                            </div>
                            <?php
                                    echo '<input type="hidden" name="user" value="'.$_SESSION["ID"].'">';
                            ?>
                            <input type="hidden" name="consented" value="Yes" >
                            <input type="submit" value="SAVE" class="btn btn-success">
                        </form>
                    </div>
                    <div class="col-3">
                        <p><strong>Alec Address (Kirkcaldy)</strong></p>
                        <p>
                            *********,<br>
                            *********,<br>
                            *********,<br>
                            *********<br>
                        </p>
                        <hr>
                        <p><strong>G's Address (*********)</strong></p>
                        <p>
                            *********,<br>
                            *********,<br>
                            *********,<br>
                            *********<br>
                        </p>
                        <hr>
                        <p class="muted"><i>(Make a note)</i></p>
                    </div>
                </div>
                <p>Alternatively, if you are uncomfortable with that, hit me up and we can arrange something else.</p>
                <form method="post" action="scripts/saveaddress.php">            
                    <?php
                            echo '<input type="hidden" name="user" value="'.$_SESSION["ID"].'">';
                    ?>
                    <input type="hidden" name="consented" value="Naw" >
                    <input type="submit" value="Nah, don't wanna" class="btn btn-info">
                </form>
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