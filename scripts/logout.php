<?php
    session_start();
    $_SESSION["role"]="guest";
    $_SESSION["logged"]=null;

    echo"<script> window.history.back();</script>";
?>