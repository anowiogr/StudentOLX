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
    header('Location: index.php');
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
        //echo "<h2>Ogłoszenia użytkownika: " . $username . "</h2>";
    }
    echo "<div><a href='addauction.php' class='button'><button class='btn btn-secondary'>Dodaj ogłoszenie</button></a></div><br>";

    // Pobranie wszystkich ogłoszeń użytkownika wraz z nazwą kategorii
    $query = "SELECT auctions.*, accounts.accountid, category.name AS category_name, auctions.veryfied
              FROM auctions
              INNER JOIN accounts ON auctions.accountid = accounts.accountid
              LEFT JOIN category ON auctions.categoryid = category.categoryid
              WHERE accounts.accountid = :accountid AND auctions.veryfied <> 2 AND auctions.selled = 0";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':accountid', $accountId);
    $statement->execute();

    $auctions = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($auctions) {
        foreach ($auctions as $auction) {
            echo <<< TABLELISTA
                <div class="row box p-3">
                    <img class="aimg" src="images/nofoto.jpg" />
                    
                    <div class="box-text" >
                    
                         <div style="width: 50%; float: left; ">
                            <h3>
                                <a class="atitle link-dark" style="text-decoration: none;" href="auction.php?auction_id=$auction[auctionid]">$auction[title]</a>
                            </h3>
                         </div>
                         
                         <div style="overflow: hidden; text-align: right;">
                            <a href="modifyauction.php?auction_id=$auction[auctionid]" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </a>
                           <a href="scripts/deleteauction.php?auction_id=$auction[auctionid]" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                              <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                            </svg>
                           </a>
                         </div>
                       <div class="ainfo ">Data wystawienia: $auction[date_start] </div>  
                    </div>
                    
                    
                   
                   
                      
                   
                   
                </div>
                
                <br>
            TABLELISTA;
        }

        echo "<hr><h4>NIEAKTYWNE</h4>";

            // Pobranie aktywnych ogłoszeń użytkownika wraz z nazwą kategorii
    $query = "SELECT auctions.*, accounts.accountid, category.name AS category_name
              FROM auctions
              INNER JOIN accounts ON auctions.accountid = accounts.accountid
              LEFT JOIN category ON auctions.categoryid = category.categoryid
              WHERE accounts.accountid = :accountid AND auctions.veryfied = 2 OR auctions.selled <> 0";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':accountid', $accountId);
    $statement->execute();

    $auctions = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($auctions) {
        foreach ($auctions as $auction) {
            echo <<< TABLELISTA
                <div class="row box p-3">
                    <img class="aimg" src="images/nofoto.jpg" />
                    
                    <div class="box-text" >
                    
                         <div style="width: 50%; float: left; ">
                            <h3>
                                <a class="atitle link-dark" style="text-decoration: none;" href="auction.php?auction_id=$auction[auctionid]">$auction[title]</a>
                            </h3>
                         </div>
                         
                         <div style="overflow: hidden; text-align: right;">
                            
                         </div>
                       <div class="ainfo ">Data wystawienia: $auction[date_start] </div>  
                    </div>

                </div>
                
                <br>
            TABLELISTA;
        }
    }

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
