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



       <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
           <div class="container">
            <a class="navbar-brand" href="./index.php"><img src="./images/icon.png" class="bi" width="40" height="40" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        <?php
            if($_SESSION["role"]=="guest"){
                ?>



               <div class="collapse navbar-collapse text-secondary justify-content-end" id="navbar-menu">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="./login.php"><button type="button" class="btn btn-outline-light me-2">Zaloguj</button></a>
                        </li>
                        <li class="nav-item">
                            <a href="./register.php"><button type="button" class="btn btn-light">Zarejestruj się</button></a>
                        </li>
                    </ul>






        <?php
            }elseif ($_SESSION["role"]=="user"){
        ?>

                   <div class="collapse navbar-collapse text-secondary justify-content-end" id="navbar-menu">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="./userauctions.php">Twoje aukcje</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./messagelist.php">Wiadomości</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./userabout.php">Ustawienia</a>
                            </li>
                            <li class="nav-item active">
                                <a href="./scripts/logout.php"><button type="button" class="btn btn-danger">Wyloguj</button></a>
                            </li>
                        </ul>


                <?php
        }elseif ($_SESSION["role"]=="admin"){
        ?>

                       <div class="collapse navbar-collapse text-secondary justify-content-end" id="navbar-menu">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="./userauctions.php">Twoje aukcje</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./messagelist.php">Wiadomości</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./admin.php">Administracja</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./userabout.php">Ustawienia</a>
                                </li>
                                <li class="nav-item active">
                                    <a href="./scripts/logout.php"><button type="button" class="btn btn-danger">Wyloguj</button></a>
                                </li>
                            </ul>

                <?php
        }
        ?>
    </div>
  </div>
</nav>
<body>
    <div class="container">
        <div class="row col-md-12 p-3">
            <div class="input-group rounded">
                <input type="search" class="form-control rounded" placeholder="Czego dzisiaj szukasz?" aria-label="Search" aria-describedby="search-addon">
                <span class="input-group-text border-0" id="search-addon">
                    <button class="btn" onclick="location.href='./auction.php';">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    </button>
                </span>
            </div>
        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
