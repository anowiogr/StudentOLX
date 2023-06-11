<?php
require 'constant/header.php';
require 'scripts/connect.php';

$title = '';
$description = '';
$used = false;
$private = false;
$dateStart = date('Y-m-d');
$dateEnd = date('Y-m-d', strtotime('+2 weeks'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $used = isset($_POST['used']);
    $private = isset($_POST['private']);
    $dateStart = $_POST['date_start'];
    $dateEnd = $_POST['date_end'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_POST['action'] === 'modify') {
            // Modyfikowanie istniejącego ogłoszenia

            $auctionId = $_POST['auction_id'];
            $accountId = $_POST['account_id'];

            // Aktualizacja ogłoszenia w bazie danych
            $query = "UPDATE auctions SET title = :title, description = :description, used = :used, private = :private, date_start = :dateStart, date_end = :dateEnd WHERE auctionid = :auctionId";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':used', $used, PDO::PARAM_BOOL);
            $stmt->bindParam(':private', $private, PDO::PARAM_BOOL);
            $stmt->bindParam(':dateStart', $dateStart);
            $stmt->bindParam(':dateEnd', $dateEnd);
            $stmt->bindParam(':auctionId', $auctionId, PDO::PARAM_INT);
            $stmt->execute();

            echo "Ogłoszenie zostało zaktualizowane.";
        } else {
            // Dodawanie nowego ogłoszenia

            $accountId = $_POST['account_id'];

            // Dodanie ogłoszenia do bazy danych
            $query = "INSERT INTO auctions (title, description, used, private, date_start, date_end, accountid) VALUES (:title, :description, :used, :private, :dateStart, :dateEnd, :accountId)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':used', $used, PDO::PARAM_BOOL);
            $stmt->bindParam(':private', $private, PDO::PARAM_BOOL);
            $stmt->bindParam(':dateStart', $dateStart);
            $stmt->bindParam(':dateEnd', $dateEnd);
            $stmt->bindParam(':accountId', $accountId, PDO::PARAM_INT);
            $stmt->execute();

            echo "Ogłoszenie zostało dodane.";
        }
    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }
} else {
    // Wyświetlanie formularza dodawania nowego ogłoszenia

    echo "<form method='POST' action='auction.php'>";
    echo "<label for='title'>Tytuł:</label><br>";
    echo "<input type='text' name='title' id='title' value='" . $title . "' required><br>";

    echo "<label for='description'>Opis:</label><br>";
    echo "<textarea name='description' id='description' required>" . $description . "</textarea><br>";

    echo "<label for='used'>Używany:</label>";
    echo "<input type='checkbox' name='used' id='used' " . ($used ? 'checked' : '') . "><br>";

    echo "<label for='private'>Prywatny:</label>";
    echo "<input type='checkbox' name='private' id='private' " . ($private ? 'checked' : '') . "><br>";

    echo "<label for='date_start'>Data rozpoczęcia:</label><br>";
    echo "<input type='text' name='date_start' id='date_start' value='" . $dateStart . "' required><br>";

    echo "<label for='date_end'>Data zakończenia:</label><br>";
    echo "<input type='text' name='date_end' id='date_end' value='" . $dateEnd . "' required><br>";

    echo "<input type='hidden' name='account_id' value='1'>"; // ID użytkownika, dla którego dodawane jest ogłoszenie

    echo "<button type='submit' name='action' value='preview'>Podgląd</button>";
    echo "<button type='submit' name='action' value='add'>Dodaj</button>";
    echo "</form>";
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
$(function() {
  $('#date_start').datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: 0,
    onSelect: function(selectedDate) {
      $('#date_end').datepicker('option', 'minDate', selectedDate);
    }
  });

  $('#date_end').datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: 0
  });
});
</script>
