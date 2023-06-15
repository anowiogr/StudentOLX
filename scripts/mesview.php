<<?php
session_start();
require 'connect.php';
print_r($_POST);
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO message (auctionid, buyerid, description, answer) VALUES (:auctionid, :buyerid, :description, :answer)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':auctionid', $_POST["auctionid"], PDO::PARAM_INT);
    $stmt->bindParam(':buyerid', $_POST["buyerid"]);
    $stmt->bindParam(':description', $_POST["description"]);
    $stmt->bindParam(':answer', $_POST["answer"]);
    $stmt->execute();

    header("location: ../messageview.php?aid=$_POST[buyerid]&bid=$_POST[buyerid]");

} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}


?>