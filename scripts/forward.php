<?php
session_start();

if(isset($_GET["categoryid"]) && $_GET["categoryid"]<>null){
    $_SESSION["filter"]["categoryid"] = $_GET["categoryid"];
    header('Location: ../auction.php');
}

if(isset($_GET["search"])){
        $_SESSION["filter"]["search"] = $_GET["search"];
    header('Location: ../auction.php');
}
?>