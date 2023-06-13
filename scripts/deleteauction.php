<?php

require 'connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "DELETE FROM auctions WHERE `auctions`.`auctionid` = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $_GET['auction_id']);
    $stmt->execute();

    header("location: ../userauctions.php");

} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}
?>