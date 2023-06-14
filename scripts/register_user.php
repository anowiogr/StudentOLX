<?php
session_start();

foreach ($_POST as $value){
	if (empty($value)){
		$_SESSION["error"] = "Wypełnij wszystkie dane!";
		echo "<script>history.back();</script>";
		exit();
	}
}
require_once "connect.php";

$error = 0;
if (!isset($_POST["terms"])){
	$error = 1;
	$_SESSION["error"] = "Zatwierdź regulamin!";
}

if ($_POST["pass1"] != $_POST["pass2"]){
	$error = 1;
	$_SESSION["error"] = "Hasła są różne!";
}

if ($_POST["email1"] != $_POST["email2"]){
	$error = 1;
	$_SESSION["error"] = "Adresy email są różne!";
}



if ($error != 0){
	echo "<script>history.back();</script>";
	exit();
}

try {

    //Insert do tabeli
    $stmt = $conn -> prepare("INSERT INTO `accounts` (`firstname`, `lastname`, `email`,`login`, `password`, `verified`) VALUES (?, ?, ?, ?,?, 0 );");
    $pass = password_hash($_POST["pass1"], PASSWORD_ARGON2ID);
    $stmt->bind_param("sssss",  $_POST["firstName"], $_POST["lastName"], $_POST["email1"],$_POST["nick"], $pass );
    $stmt->execute();

	if ($stmt->affected_rows != 0){
		$_SESSION["success"] = "Zostałeś zarejestrowany, poczekaj na weryfikację administratora";
		header("location: ../");
	}
} catch (mysqli_sql_exception $e) {
		$_SESSION["error"] = $e->getMessage();
		echo "<script>history.back();</script>";
		exit();
}














