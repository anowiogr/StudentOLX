<?php

require 'connect.php';
print_r($_GET);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_GET["verifyed"]=="true") {
        $query = "UPDATE auctions SET veryfied = '1', whover=:id WHERE auctionid = :auctionid;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $_GET["id"]);
        $stmt->bindParam(':auctionid', $_GET["auction_id"]);
        $stmt->execute();

        header("location: ../admin.php");
    }elseif($_GET["verifyed"]=="false"){
        $query = "UPDATE auctions SET veryfied = '2', whover=:id WHERE auctionid = :auctionid;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $_GET["id"]);
        $stmt->bindParam(':auctionid', $_GET["auction_id"]);
        $stmt->execute();
        header("location: ../admin.php");
    }

} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}

?>