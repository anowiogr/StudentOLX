<?php
include_once "constant/header.php";
require "scripts/connect.php";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_SESSION['info']) && $_SESSION['info']<> null){

        echo "<div class='alert alert-success' role='alert'>$_SESSION[info]</div>";
        $_SESSION['info']=null;
    }

    // Sprawdzenie, czy przesłano ID aukcji
    if (isset($_GET['auction_id'])) {
        $auctionId = $_GET['auction_id'];

        // Pobranie informacji o wybranej aukcji
        $query = "SELECT a.*, u.login, u.phone, c.currency_name FROM auctions a
                  LEFT JOIN accounts u ON a.accountid = u.accountid
                  LEFT JOIN currency c ON a.currencyid = c.currencyid
                  WHERE a.auctionid = :auctionId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':auctionId', $auctionId, PDO::PARAM_INT);
        $stmt->execute();
        $auction = $stmt->fetch(PDO::FETCH_ASSOC);

        // Wyświetlanie informacji o wybranej aukcji
        if ($auction) {
            ?>
                <div class="row col-md-1">
                    <button style="border: 0px;" onclick="goBack()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="dark" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                        <!--Wróć do widoku wszystkich aukcji-->
                    </button>
                </div>
                <div class="row col-md-11">
                    <div class="col-md-6">
                        <img class="fill" src="images/nofoto.jpg" />
                    </div>

                    <div class="p-3 mb-2 col-md-6" style="text-align: right;">

                            <h4>
                                <b>Sprzedający:</b> <?php echo $auction["login"]; ?><br><br>
                                <b>Telefon:</b> <?php echo ($_SESSION["role"]=="guest" ?  "Zaloguj się aby zobaczyć nr telefonu" : $auction['phone']); ?> <br><br>
                            </h4>
                            <a class='btn btn-secondary' <?php echo "href='newmessage.php?auction_id=$auctionId'"; ?> >
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-send' viewBox='0 0 16 16'>
                                <path d='M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z'/>
                            </svg> Napisz wadomość </a>
                            <br><br><br>
                            <h2><?php echo $auction["price"]." ".$auction["currency_name"]; ?></h2>

                    </div>

                    <div>
                        <p style="text-align: right; font-size: 0.8em;">Data wystawienia: <?php echo $auction["date_start"]; ?></p>
                        <h1><i><?php echo $auction["title"]; ?></i></h1>
                        <br>
                        <span>
                            <?php echo $auction["description"]; ?>
                            <br><br>
                            <?php
                            echo "Używany: ";
                            echo ($auction['used'] ?
                                '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
                                  <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                                </svg>' :
                                '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-toggle-off" viewBox="0 0 16 16">
                                  <path d="M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z"/>
                                </svg>');
                            ?>
                            <br>
                            <?php
                            echo "Prywatny: ";
                            echo ($auction['private'] ?
                                '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
                                  <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                                </svg>' :
                                '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-toggle-off" viewBox="0 0 16 16">
                                  <path d="M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z"/>
                                </svg>');
                            ?>
                        </span>
                    </div>
                </div><br><br>
            <?php

        } else {
            echo "Aukcja o podanym ID nie istnieje.";
        }
    } else {

                //Pobranie przefiltrowanych aukcji z podstawowymi informacjami
                if(isset($_SESSION["filter"]["search"])&& $_SESSION["filter"]["search"]<>null&& $_SESSION["filter"]["search"]<>''){

                    $searchbar="'%".$_SESSION["filter"]["search"]."%'";
                    print_r($searchbar."<br>");

                    $query = "SELECT * FROM auctions a
                                LEFT JOIN accounts u ON a.accountid = u.accountid 
                                LEFT JOIN currency c ON a.currencyid = c.currencyid
                                WHERE a.selled = 0 AND a.veryfied = 1 
                                AND a.title LIKE :searchbar
                                OR a.description LIKE :searchbar";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':searchbar', $searchbar);
                    $stmt->execute();

                    $_SESSION["filter"]["search"]=null;

                    } elseif(isset($_SESSION["filter"]["categoryid"])&& $_SESSION["filter"]["categoryid"]<>null) {


                    $categoryid = $_SESSION["filter"]["categoryid"];
                    //print_r($categoryid . "<br>");

                    $query = "SELECT * FROM auctions a
                                LEFT JOIN accounts u ON a.accountid = u.accountid 
                                LEFT JOIN currency c ON a.currencyid = c.currencyid
                                WHERE a.selled = 0 AND a.veryfied = 1 
                                AND a.categoryid = :categoryid";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':categoryid', $categoryid);
                    $stmt->execute();
                    $_SESSION["filter"]["categoryid"]=null;

                } else {
                    $query = "SELECT * FROM auctions a
                                LEFT JOIN accounts u ON a.accountid = u.accountid 
                                LEFT JOIN currency c ON a.currencyid = c.currencyid
                            WHERE a.selled = 0 AND a.veryfied = 1";
                    $stmt = $pdo->query($query);
                }

                $auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);


                //print_r($auctions);
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
                         <h3>$auction[price]</h3>$auction[currency_name]
                         </div>
                      <div class="ainfo" style="text-align: left;" >$auction[city],  Data wystawienia: $auction[date_start] </div>   
                    </div>
                    
                
                </div>
            TABLELISTA;

        } echo "<br>";
    }


} catch (PDOException $e) {
    die("Błąd połączenia lub tworzenia bazy danych: " . $e->getMessage());
}

require 'constant/footer.php';
?>
