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
/*
    $stmt = $conn->query("SELECT * FROM `accounts` WHERE `login` = $_POST["nick"];");
    //$stmt->execute();
    //echo $stmt -> num_rows;
    if($stmt -> num_rows > 0){
        $error = 1;
        $_SESSION["error"] = "Podany nick istnieje już w bazie";

    }
    $stmt-> close();*/

if ($error != 0){
	echo "<script>history.back();</script>";
	exit();
}

try {

    //Insert do tabeli users
    $stmt = $conn->prepare("INSERT INTO `users` (`firstname`, `lastname`, `email`) VALUES ( ?, ?, ? );");
    $stmt->bind_param("sss",  $_POST["firstName"], $_POST["lastName"], $_POST["email1"] );
    $stmt->execute();
    $stmt->close();

    //Wykonanie nadania id
    $stmt = $conn->query("SELECT max(userid) as id FROM `users`;");
    while($row = $stmt -> fetch_assoc()){
        $id = $row["id"];
    }
    $stmt -> close();

    //Insert do tabeli accounts
    $stmt = $conn -> prepare("INSERT INTO `accounts` (`userid`,`login`, `password`, `verified`) VALUES (?, ?, ?, 0 );");
    $pass = password_hash($_POST["pass1"], PASSWORD_ARGON2ID);
    $stmt->bind_param("sss",  $id,$_POST["nick"], $pass );
    $stmt->execute();

	if ($stmt->affected_rows != 0){
		$_SESSION["success"] = "Prawidłowo dodano użytkownika";
		header("location: ../");
	}
} catch (mysqli_sql_exception $e) {
		$_SESSION["error"] = $e->getMessage();
		echo "<script>history.back();</script>";
		exit();
}














