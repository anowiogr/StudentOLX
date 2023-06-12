<?php
include_once "constant/header.php";
require 'scripts/connect.php';
?>
<body class="d-flex flex-column h-100">
<div class="container prelative"><br>
<?php
// Sprawdzenie, czy przekazano account_id w GET
if (isset($_GET['account_id'])) {
    $accountId = $_GET['account_id'];
} elseif (isset($_SESSION['logged']['account_id'])) {
    $accountId = $_SESSION['logged']['account_id'];
} else {
    // Przekierowanie na stronę logowania, jeśli brak account_id w GET i sesji
    header('Location: login.php');
    exit();
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pobranie nazwy użytkownika
    $query = "SELECT firstname, lastname FROM accounts WHERE accountid = :accountid";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':accountid', $accountId);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = $user['firstname'] . ' ' . $user['lastname'];
        echo "<h2>Ogłoszenia użytkownika: " . $username . "</h2>";
    }
    echo "<div class='p-1'><a href='addauction.php' class='button'><button class='btn btn-secondary'>Dodaj ogłoszenie</button></a></div>";
    // Pobranie wszystkich ogłoszeń użytkownika wraz z nazwą kategorii
    $query = "SELECT auctions.*, accounts.accountid, category.name AS category_name
              FROM auctions
              INNER JOIN accounts ON auctions.accountid = accounts.accountid
              LEFT JOIN category ON auctions.categoryid = category.categoryid
              WHERE accounts.accountid = :accountid";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':accountid', $accountId);
    $statement->execute();

    $auctions = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($auctions) {
        foreach ($auctions as $auction) {
            echo <<< TABLELISTA
                <div class="row box p-3">
                    <img class="aimg" src="images/nofoto.jpg" />
                    <div class="box-text">
                    <h3><a class="atitle link-dark" href="auction.php?auction_id=$auction[auctionid]">$auction[title]</a></h3>
                     <div class="justify-content-end">
                        <button class="btn btn-outline-secondary">Zmień</button>
                       <button class="btn btn-outline-danger">Usuń</button>
                     </div></div>
                   <div class="ainfo text-right" width="100%">Data wystawienia: $auction[date_start] </div>
                   
                   
                      
                   
                   
                </div>
                
                <br>
            TABLELISTA;
        }
        echo "</table>";
    } else {
        echo "<p class='text-secondary p-3'><i>Nie masz jeszcze żadnych ogłoszeń, dodaj ogłoszenie i zarabiaj!</i></p>";

    }
} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}
   // echo "<a href='addauction.php' class='button'><button class='btn btn-secondary'>Dodaj ogłoszenie</button></a>";
?>
</div>
</body>
<?php
require 'constant/footer.php';
?>
