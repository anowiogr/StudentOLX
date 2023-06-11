<?php
require 'scripts/connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pobranie wszystkich aukcji użytkownika
        $query = "SELECT auctions.*, users.userid
                  FROM auctions
                  INNER JOIN accounts ON auctions.accountid = accounts.accountid
                  INNER JOIN users ON accounts.userid = users.userid
                  WHERE users.userid = :userid";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':userid', $userId);
        $statement->execute();

        $auctions = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($auctions) {
            echo "<h2>Aukcje użytkownika o ID: " . $userId . "</h2>";
            echo "<table>";
            echo "<tr><th>ID aukcji</th><th>Tytuł</th><th>Data rozpoczęcia</th><th>Data zakończenia</th><th>Sprzedane</th></tr>";
            foreach ($auctions as $auction) {
                echo "<tr>";
                echo "<td>" . $auction['auctionid'] . "</td>";
                echo "<td>" . $auction['title'] . "</td>";
                echo "<td>" . $auction['date_start'] . "</td>";
                echo "<td>" . $auction['date_end'] . "</td>";
                echo "<td>" . ($auction['selled'] ? 'Tak' : 'Nie') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='info'>Brak aukcji dla użytkownika o podanym ID.</p>";
        }
    } else {
        
    }
} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}
echo "<p class='info'>Wpisz ID użytkownika, aby wyświetlić jego aukcje.</p>";
        echo "<form method='POST' action=''>";
        echo "<label for='user_id'>ID użytkownika:</label>";
        echo "<input type='text' name='user_id' id='user_id' value='" . $userId . "' required>";
        echo "<button type='submit'>Zatwierdź</button>";
        echo "</form>";
?>
