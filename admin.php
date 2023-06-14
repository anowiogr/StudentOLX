<?php
include_once "constant/header.php";
require "scripts/connect.php";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $account_id = $_SESSION["logged"]["account_id"];

//Sprawdzenie czy user jest adminem
$query = "SELECT account_type FROM accounts WHERE accountid = :accountid";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':accountid', $account_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user['account_type']<>101){
    header('Location: index.php');
    exit();
}
?>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="auctiontab" data-bs-toggle="tab" data-bs-target="#buy" type="button" role="tab" aria-controls="buy" aria-selected="true">Aukcje - weryfikacja</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="newusertab" data-bs-toggle="tab" data-bs-target="#sell" type="button" role="tab" aria-controls="sell" aria-selected="false">Konta - weryfikacja </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="buy" role="tabpanel" aria-labelledby="auctiontab"><br>

<?php

        // Pobranie wszystkich aukcji z podstawowymi informacjami
        $query = "SELECT 
                    a.auctionid, a.title, a.selled, u.firstname, u.lastname, u.city, a.date_start, a.price, c.currency_name
                    FROM auctions a
                    LEFT JOIN accounts u ON a.accountid = u.accountid 
                    LEFT JOIN currency c ON a.currencyid = c.currencyid
                    WHERE a.veryfied = 0";
        $stmt = $pdo->query($query);
        $auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Wyświetlanie wszystkich aukcji z podstawowymi informacjami
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
                         <h3>$auction[price]</h3>$auction[currency_name]<br>
                           <a href="scripts/modauction.php?auction_id=$auction[auctionid]&verifyed=true&id=$account_id" class="btn btn-success">Zatwierdź</a><!--wartość na 1-->
                           <a  href="scripts/modauction.php?auction_id=$auction[auctionid]&verifyed=false&id=$account_id" class="btn btn-danger">Odrzuć</a> <!--wartość na 2-->
                         </div><div class="ainfo" style="text-align: left;" >$auction[city],  Data wystawienia: $auction[date_start] </div>
                       
                    </div>
                    
                
                </div>
            TABLELISTA;

        }
    ?>
                    </div>
                    <div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="newusertab">
                        <br>
                        <?php

                        // Pobranie wszystkich nowych userów
                        $query1 = "SELECT * FROM `accounts` WHERE `verified` = 0;";
                        $stmt1 = $pdo->query($query1);
                        $newUsers = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                        echo "<h5>Oczekujące</h5>";
                        // Wyświetlanie wszystkich aukcji z podstawowymi informacjami
                        foreach ($newUsers as $newUser) {

                                echo <<< TABLELISTAU
                            <div class="row box p-3">  
                            <br>                          
                                <div class="box-text" >
                                
                                     <div style="width: 50%; float: left; ">
                                        <h3>$newUser[login]</h3>
                                        <p>
                                            $newUser[firstname] $newUser[lastname]
                                            <br>
                                            <i style="font-size: 0.9em">$newUser[email]</i>
                                        </p>
                                     </div>
                                     
                                     <div style="overflow: hidden; text-align: right;">
                                       <p style="font-size: 0.7em;" > Data rejestracji: $newUser[registerdate] </p>
                                       <a href="scripts/moduser.php?accountid=$newUser[accountid]&verifyed=true&id=$account_id" class="btn btn-success">Zatwierdź</a><!--wartość na 1-->
                                       <a  href="scripts/moduser.php?accountid=$newUser[accountid]&verifyed=false&id=$account_id" class="btn btn-danger">Odrzuć</a> <!--wartość na 2-->
                                     </div>
                                     
                                   
                                </div>
                                
                            
                            </div>
                        TABLELISTAU;
                        }
                        ?>
                        <br><hr>
                        <h5>Odrzucone</h5>
                        <?php
                        // Pobranie wszystkich nowych userów
                        $query1 = "SELECT * FROM `accounts` WHERE `verified` = 2;";
                        $stmt1 = $pdo->query($query1);
                        $newUsers = $stmt1->fetchAll(PDO::FETCH_ASSOC);


                        // Wyświetlanie wszystkich aukcji z podstawowymi informacjami
                        foreach ($newUsers as $newUser) {

                            echo <<< TABLELISTAU
                            <div class="row box p-3">  
                            <br>                          
                                <div class="box-text" >
                                
                                     <div style="width: 50%; float: left; ">
                                        <h3>$newUser[login]</h3>
                                        <p>
                                            $newUser[firstname] $newUser[lastname]
                                            <br>
                                            <i style="font-size: 0.9em">$newUser[email]</i>
                                        </p>
                                     </div>
                                     
                                     <div style="overflow: hidden; text-align: right;">
                                       <p style="font-size: 0.7em;" > Data rejestracji: $newUser[registerdate] </p>
                                     </div>
                                     
                                   
                                </div>
                                
                            
                            </div>
                        TABLELISTAU;
                        }
                        ?>
                    </div>
    </div>

 <?php
} catch (PDOException $e) {
    die("Błąd połączenia lub tworzenia bazy danych: " . $e->getMessage());
}

require 'constant/footer.php';
?>
