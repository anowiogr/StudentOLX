<?php

require 'connect.php';
//print_r($_POST);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "INSERT INTO auctions (title, description, used, private, date_start, date_end, accountid) VALUES (:title, :description, :used, :private, current_timestamp, (current_timestamp+30), :accountId)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':title', $_POST["title"]);
$stmt->bindParam(':description', $_POST["description"]);
$stmt->bindParam(':used', $_POST["used"], PDO::PARAM_BOOL);
$stmt->bindParam(':private', $_POST["private"], PDO::PARAM_BOOL);
//$stmt->bindParam(':dateStart', $dateStart);
//$stmt->bindParam(':dateEnd', $dateEnd);
$stmt->bindParam(':accountId', $_POST["account_id"], PDO::PARAM_INT);

$stmt->execute();

    header("location: ../userauctions.php");

} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}

?>