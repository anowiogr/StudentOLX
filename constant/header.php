<?php

    session_start();

    if (!isset($_SESSION["role"])){
        $_SESSION["role"]="guest";
    }

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
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

                    <ul class="navbar-nav">
                        </li>
                        <br />
                        <li class="nav-item active">
                            <a href="#">
                            <button type="button" class="btn btn-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            </svg>
                            Twoje konto</button>
                            </a>
                        </li>
                    </ul>

                </div>

                <?php
        }elseif ($_SESSION["role"]=="admin"){
        ?>
        <div class="collapse navbar-collapse text-secondary justify-content-end" id="navbar-menu">

        <ul class="navbar-nav">
            </li>
            <br />
            <li class="nav-item active">
                <a href="#">
                    <button type="button" class="btn btn-light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
                        </svg>
                        Twoje konto</button>
                </a>
            </li>
        </ul>

    </div>
        <?php
        }
        ?>

    </div>
</nav>

<?php

print_r($_SESSION["role"]);

?>
