<?php
    session_start();
    $_SESSION["role"]="guest";
    $_SESSION["logged"]=null;

    header("location: ../index.php");
?>