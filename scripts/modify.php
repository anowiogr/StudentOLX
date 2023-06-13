<?php

require 'connect.php';
print_r($_POST);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $query = "UPDATE auctions SET title = :title, description = :description, used = :used, private = :priv WHERE auctionid = :auctionId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':title', $_POST["title"]);
    $stmt->bindParam(':description', $_POST["description"]);
    $stmt->bindParam(':used', $_POST["used"], PDO::PARAM_BOOL);
    $stmt->bindParam(':priv', $_POST["private"], PDO::PARAM_BOOL);
    $stmt->bindParam(':auctionId', $_POST["auction_id"], PDO::PARAM_INT);
    $stmt->execute();

    header("location: ../userauctions.php");


} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}
?>