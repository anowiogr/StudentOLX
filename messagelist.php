<?php
require "constant/header.php";
require 'scripts/connect.php';

if (!isset($_SESSION['logged']['account_id'])||$_SESSION['logged']['account_id']==null) {
    header("Location: index.php");

}
$account_id = $_SESSION['logged']['account_id'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("USE $dbname");

    //Zapytanie dla sprzedawanych przedmiotów (naglowek)
    $querySell = "SELECT 
    DISTINCT m.auctionid, m.buyerid, x.accountid as seller, a.login, x.title
    FROM message m 
     LEFT JOIN auctions x ON m.auctionid = x.auctionid
     LEFT JOIN accounts a ON m.buyerid = a.accountid 
   WHERE m.answer !=0 AND x.accountid = :accountid";
    $stmtSell = $pdo->prepare($querySell);
    $stmtSell->bindValue(':accountid', $account_id);
    $stmtSell->execute();

    // Zapytanie dla kupowanych (naglowek)
    $queryBuy = "SELECT 
    DISTINCT m.auctionid, m.buyerid, x.accountid as seller, a.login, x.title
    FROM message m 
     LEFT JOIN auctions x ON m.auctionid = x.auctionid
     LEFT JOIN accounts a ON m.buyerid = a.accountid 
   WHERE m.answer !=0 AND x.accountid <> :accountid";
    $stmtBuy = $pdo->prepare($queryBuy);
    $stmtBuy->bindParam(':accountid', $account_id);
    $stmtBuy->execute();


} catch (PDOException $e) {
    echo "Błąd połączenia lub aktualizacji bazy danych: " . $e->getMessage();
}


?>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="messageBuy-tab" data-bs-toggle="tab" data-bs-target="#buy" type="button" role="tab" aria-controls="buy" aria-selected="true">Kupujesz</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="messageSell-tab" data-bs-toggle="tab" data-bs-target="#sell" type="button" role="tab" aria-controls="sell" aria-selected="false">Sprzedajesz</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">

            <!--WIADOMOŚCI OD UZYTKOWNIKÓW-->
            <div class="tab-pane fade show active" id="buy" role="tabpanel" aria-labelledby="messageBuy-tab">


                <?php
                // Wyświetlanie wiadomości od zainteresowanych (naglowki)
                while ($rowBuy = $stmtBuy->fetch(PDO::FETCH_ASSOC)) {
                echo <<< TABLEMESSLIST
                        <div class="row box p-3">  
                            <br>                          
                                <div class="box-text" >
                                
                                     <div style="width: 50%; float: left; ">
                                        <h3>$rowBuy[login]</h3>
                                        <p>
                                            <i style="font-size: 0.9em">$rowBuy[title]</i>
                                        </p>
                                     </div>
                                     
                                     <div style="overflow: hidden; text-align: right;">
                                     <br>
                                       <a href="messageview.php?aid=$rowBuy[auctionid]&bid=$rowBuy[buyerid]&a=0" class="btn btn-outline-secondary">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                          <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                                        </svg>
                                        </a>
                                     </div>
                                     
                                   
                                </div>
                                
                            
                            </div>
             TABLEMESSLIST;
                }
                ?>


            </div>


            <div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="messageSell-tab">
                <br />
                <?php
                while ($rowSell = $stmtSell->fetch(PDO::FETCH_ASSOC)) {
                    echo <<< TABLEMESSLIST
                        <div class="row box p-3">  
                            <br>                          
                                <div class="box-text" >
                                
                                     <div style="width: 50%; float: left; ">
                                        <h3>$rowSell[login]</h3>
                                        <p>
                                            <i style="font-size: 0.9em">$rowSell[title]</i>
                                        </p>
                                     </div>
                                     
                                     <div style="overflow: hidden; text-align: right;">
                                     <br>
                                       <a href="messageview.php?aid=$rowSell[auctionid]&bid=$rowSell[buyerid]&a=1" class="btn btn-outline-secondary">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                          <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                                        </svg>
                                        </a>
                                     </div>
                                     
                                   
                                </div>
                                
                            
                            </div>
             TABLEMESSLIST;
                }
                ?>
            </div>
        </div>
    </div>

<?php
include_once "constant/footer.php";
?>
