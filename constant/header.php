<?php

    session_start();
    //print_r($_SESSION["logged"]);
    if (!isset($_SESSION["role"])){
        $_SESSION["role"]="guest";
    }

//do wywalenia
//print_r($_SESSION['logged']);

?>
<!doctype html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="description"
          content="Strona stworzona w celach nauki programowania www. Studencki OLX to strona stworzona, aby przećwiczyć tworzenie kodu w HTML|PHP|JavaScript w powiązaniu z SQL.">
    <link rel="icon"
          type="image/png" href="./images/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/style.css">

    <title>Studencki OLX</title>
    </head>



<nav class="navbar navbar-expand-sm fixed-top navbar-dark bg-dark" style="position: relative;">

    <div class="container">

        <a href="./index.php"><img src="./images/icon.png" class="bi" width="40" height="40" /></a>

        <button type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" class="navbar-toggler justify-content-center" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <?php
            if($_SESSION["role"]=="guest"){
                ?>
            <div class="collapse navbar-collapse text-secondary justify-content-end" id="navbar-menu">

            <ul class="navbar-nav">
                <br />
                <li class="nav-item active">
                    <a href="./login.php"><button type="button" class="btn btn-outline-light me-2">Zaloguj</button></a>


                </li>
                <br />
                <li class="nav-item active">
                    <a href="./register.php"><button type="button" class="btn btn-light">Zarejestruj się</button></a>
                </li>
            </ul>

        </div>

        <?php
            }elseif ($_SESSION["role"]=="user"){
        ?>

        <div class="collapse navbar-collapse text-secondary justify-content-end" id="navbar-menu">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./userauctions.php">Aukcje</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./wiadomosci.php">Wiadomości</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./userabout.php">Ustawienia</a>
                </li>
                <li class="nav-item active">
                        <a href="./scripts/logout.php"><button type="button" class="btn btn-danger">Wyloguj</button></a>
                </li>
            </ul>
        </div>
                <?php
        }elseif ($_SESSION["role"]=="admin"){
        ?>

                <div class="collapse navbar-collapse text-secondary justify-content-end" id="navbar-menu">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./userauctions.php">Aukcje</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./wiadomosci.php">Wiadomości</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Administracja</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./userabout.php">Ustawienia</a>
                        </li>
                        <li class="nav-item active">
                            <a href="./scripts/logout.php"><button type="button" class="btn btn-danger">Wyloguj</button></a>
                        </li>
                    </ul>
                </div>

                <?php
        }
        ?>

    </div>
</nav>
<body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
