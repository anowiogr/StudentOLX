<?php

require 'connect.php';
print_r($_GET);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_GET["verifyed"]=="true") {
        $query = "UPDATE accounts SET verified = '1', whover=:id WHERE accountid = :accountid;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $_GET["id"]);
        $stmt->bindParam(':accountid', $_GET["accountid"]);
        $stmt->execute();
        header("location: ../admin.php");

    }elseif($_GET["verifyed"]=="false"){
        $query = "UPDATE accounts SET verified = '2', whover=:id WHERE accountid = :accountid;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $_GET["id"]);
        $stmt->bindParam(':accountid', $_GET["accountid"]);
        $stmt->execute();
        header("location: ../admin.php");
    }

} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}

?>