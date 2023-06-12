<?php
require "constant/header.php";
require 'scripts/connect.php';


// Sprawdzenie czy użytkownik jest zalogowany

if (!isset($_SESSION['account_id'])) {
    // Przekierowanie użytkownika na stronę logowania lub inny odpowiedni komunikat
    header("Location: login.php");
    exit();
}

// Odczytanie account_id z sesji
$account_id = $_SESSION['account_id'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("USE $dbname");

    // Zapytanie dla wiadomości sprzedawanych
    $querySell = "SELECT message.description, auctions.title
                  FROM message
                  INNER JOIN auctions ON message.auctionid = auctions.auctionid
                  WHERE message.mlid IN (SELECT mlid FROM message_link WHERE sellerid = :account_id)
                  AND message.auctionid IN (SELECT auctionid FROM auctions WHERE accountid = :account_id)";
    $stmtSell = $pdo->prepare($querySell);
    $stmtSell->bindValue(':account_id', $account_id);
    $stmtSell->execute();

    // Zapytanie dla wiadomości kupowanych
    $queryBuy = "SELECT message.description, auctions.title
                 FROM message
                 INNER JOIN auctions ON message.auctionid = auctions.auctionid
                 WHERE message.mlid IN (SELECT mlid FROM message_link WHERE buyerid = :account_id)
                 AND message.auctionid NOT IN (SELECT auctionid FROM auctions WHERE accountid = :account_id)";
    $stmtBuy = $pdo->prepare($queryBuy);
    $stmtBuy->bindValue(':account_id', $account_id);
    $stmtBuy->execute();

    // Wyświetlanie wiadomości sprzedawanych
    echo "Wiadomości sprzedawanych:<br>";
    while ($rowSell = $stmtSell->fetch(PDO::FETCH_ASSOC)) {
        echo "Tytuł aukcji: " . $rowSell['title'] . "<br>";
        echo "Opis wiadomości: " . $rowSell['description'] . "<br><br>";
    }

    // Wyświetlanie wiadomości kupowanych
    echo "Wiadomości kupowanych:<br>";
    while ($rowBuy = $stmtBuy->fetch(PDO::FETCH_ASSOC)) {
        echo "Tytuł aukcji: " . $rowBuy['title'] . "<br>";
        echo "Opis wiadomości: " . $rowBuy['description'] . "<br><br>";
    }

} catch (PDOException $e) {
    echo "Błąd połączenia lub aktualizacji bazy danych: " . $e->getMessage();
}
?>




<body class="d-flex flex-column h-100">

    <br />
    <div class="container prelative">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="messageBuy-tab" data-bs-toggle="tab" data-bs-target="#buy" type="button" role="tab" aria-controls="buy" aria-selected="true">Kupujesz</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="messageSell-tab" data-bs-toggle="tab" data-bs-target="#sell" type="button" role="tab" aria-controls="sell" aria-selected="false">Sprzedajesz</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="buy" role="tabpanel" aria-labelledby="messageBuy-tab">
                <br />
                Twoje wiadomości dotyczące zakupów.
            </div>
            <div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="messageSell-tab">
                <br />
                Twoje wiadomości dotyczące przedmiotów sprzedawanych.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

<?php
include_once "constant/footer.php";
?>
