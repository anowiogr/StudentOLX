<?php

session_start();


    foreach ($_POST as $value) {
        if (empty($value)) {
            $_SESSION["error"] = "Wypełnij wszystkie dane!";
            echo "<script>history.back();</script>";
            exit();
        }
    }

require_once "connect.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_POST["pass1"]==$_POST["pass2"]){

        $pass = password_hash($_POST["pass1"], PASSWORD_ARGON2ID);

        $stmt = $pdo->prepare("UPDATE accounts SET password = :paswd WHERE login= :login AND email = :email");
        $stmt->bindParam(':paswd', $pass);
        $stmt->bindParam(':login', $_POST["login"]);
        $stmt->bindParam(':email', $_POST["email"]);
        $stmt->execute();

        $_SESSION["succes"] = "Hasło zostało zmienione";
        header("location: ../login.php");


    } else {
        $_SESSION["error"] = "Hasła nie są identyczne!";
        echo "<script>history.back();</script>";
    }

} catch (mysqli_sql_exception $e) {
	$_SESSION["error"] = $e->getMessage();
	echo "error";
    echo $_SESSION["error"];
	exit();
}


?>
