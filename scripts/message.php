<?php
session_start();
require 'connect.php';
print_r($_POST);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO message (auctionid, buyerid, description) VALUES (:auctionid, :buyerid, :description)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':auctionid', $_POST["auction_id"], PDO::PARAM_INT);
    $stmt->bindParam(':buyerid', $_POST["account_id"]);
    $stmt->bindParam(':description', $_POST["description"]);
    $stmt->execute();

    header("location: ../auction.php?auction_id=$_POST[auction_id]");
    $_SESSION["info"] = "Wiadomość została wysłana";

} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}


?>