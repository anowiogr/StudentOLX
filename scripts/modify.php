<?php

require 'connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $query = "UPDATE auctions 
            SET title = :title, description = :description, used = :used, private = :private, categoryid = :categoryid, price = :price, currencyid = :currencyid 
            WHERE auctionid = :auctionId";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':title', $_POST["title"]);
    $stmt->bindParam(':description', $_POST["description"]);
    $stmt->bindParam(':used', $_POST["used"], PDO::PARAM_BOOL);
    $stmt->bindParam(':private', $_POST["private"], PDO::PARAM_BOOL);
    $stmt->bindParam(':categoryid', $_POST["categoryid"], PDO::PARAM_INT);
    $stmt->bindParam(':price', $_POST["price"]);
    $stmt->bindParam(':currencyid', $_POST["currencyid"], PDO::PARAM_INT);
    $stmt->bindParam(':auctionId', $_POST["auctionid"], PDO::PARAM_INT);
    $stmt->execute();

    header("location: ../userauctions.php");


} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}
?>