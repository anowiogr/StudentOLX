<?php
include_once "constant/header.php";
require 'scripts/connect.php';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sprawdzenie, czy przesłano ID aukcji
    if (isset($_GET['auction_id'])) {
        $auctionId = $_GET['auction_id'];

        // Pobranie informacji o wybranej aukcji
        $query = "SELECT a.*, u.firstname, u.lastname FROM auctions a
                  INNER JOIN accounts u ON a.accountid = u.accountid
                  WHERE a.auctionid = :auctionId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':auctionId', $auctionId, PDO::PARAM_INT);
        $stmt->execute();
        $auction = $stmt->fetch(PDO::FETCH_ASSOC);

        // Wyświetlanie informacji o wybranej aukcji
        if ($auction) {
            echo "Aukcja ID: " . $auction['auctionid'] . "<br>";
            echo "Tytuł: " . $auction['title'] . "<br>";
            echo "Opis: " . $auction['description'] . "<br>";
            echo "Używany: " . ($auction['used'] ? 'Tak' : 'Nie') . "<br>";
            echo "Prywatny: " . ($auction['private'] ? 'Tak' : 'Nie') . "<br>";
            echo "Data rozpoczęcia: " . $auction['date_start'] . "<br>";
            echo "Data zakończenia: " . $auction['date_end'] . "<br>";
            echo "Sprzedany: " . ($auction['selled'] ? 'Tak' : 'Nie') . "<br>";
            echo "ID kupującego: " . $auction['buyerid'] . "<br>";
            echo "Sprzedający: " . $auction['firstname'] . " " . $auction['lastname'] . "<br>";
            echo "<br>";

            // Przycisk "Wróć do widoku wszystkich aukcji"
            echo '<a href="auction.php">Wróć do widoku wszystkich aukcji</a>';
        } else {
            echo "Aukcja o podanym ID nie istnieje.";
        }
    } else {
        // Pobranie wszystkich aukcji z podstawowymi informacjami
        $query = "SELECT a.auctionid, a.title, a.selled, u.firstname, u.lastname FROM auctions a
                  INNER JOIN accounts u ON a.accountid = u.accountid";
        $stmt = $pdo->query($query);
        $auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Wyświetlanie wszystkich aukcji z podstawowymi informacjami
        foreach ($auctions as $auction) {
            echo "Aukcja ID: " . $auction['auctionid'] . "<br>";
            echo "Tytuł: " . $auction['title'] . "<br>";
            echo "Sprzedający: " . $auction['firstname'] . " " . $auction['lastname'] . "<br>";
            echo "Oferta aktualna: " . ($auction['selled'] ? 'Nie' : 'Tak') . "<br>";
            echo '<a href="auction.php?auction_id=' . $auction['auctionid'] . '">Pokaż szczegóły</a>';
            echo "<br>";
        }
    }

} catch (PDOException $e) {
    die("Błąd połączenia lub tworzenia bazy danych: " . $e->getMessage());
}
require 'constant/footer.php';
?>
