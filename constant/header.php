<?php

    session_start();
    //print_r($_SESSION["logged"]);
    if (!isset($_SESSION["role"])){
        $_SESSION["role"]="guest";
    }

//do wywalenia
print_r($_SESSION['logged']);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
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

                <div class="dropdown show">

                    <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" id="navbar-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                        </svg>
                        Twoje konto
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">Aukcje</a>
                        <a class="dropdown-item" href="#">Wiadomości</a>
                        <a class="dropdown-item" href="#">Ustawienia</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Wyloguj</a>
                    </div>
                </div>
                <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="./scripts/logout.php"><button type="button" class="btn btn-danger">Wyloguj</button></a>
                </li>
                </ul>

                <?php
        }elseif ($_SESSION["role"]=="admin"){
        ?>
                <div class="dropdown show">

                    <a class="btn btn-light dropdown-toggle" href="#" role="button" id="navbar-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                        </svg>
                        Twoje konto
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">Aukcje</a>
                        <a class="dropdown-item" href="#">Wiadomości</a>
                        <a class="dropdown-item" href="#">Moderowanie</a>
                        <a class="dropdown-item" href="#">Ustawienia</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Wyloguj</a>
                    </div>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item active">

                        <a href="./scripts/logout.php"><button type="button" class="btn btn-danger">Wyloguj</button></a>


                    </li>
                </ul>

                <?php
        }
        ?>

    </div>
</nav>

