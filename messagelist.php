<?php
require "constant/header.php";
require 'scripts/connect.php';
//print_r($_SESSION['logged']['account_id']);
// Sprawdzenie czy użytkownik jest zalogowany
if (!isset($_SESSION['logged']['account_id'])||$_SESSION['logged']['account_id']==null) {
    // Przekierowanie użytkownika na stronę logowania lub inny odpowiedni komunikat
    header("Location: index.php");
    //exit();
}

// Odczytanie account_id z sesji
$account_id = $_SESSION['logged']['account_id'];
//print_r($account_id);
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("USE $dbname");

    //Zapytanie dla nagłówków wiadomości sprzedawanych
    $querySell = "SELECT auctions.title, auctions.auctionid
                  FROM message
                  INNER JOIN auctions ON message.auctionid = auctions.auctionid
                  WHERE message.mlid IN (SELECT mlid FROM message_link WHERE sellerid = :account_id)
                  AND auctions.accountid = :account_id";
    $stmtSell = $pdo->prepare($querySell);
    $stmtSell->bindValue(':account_id', $account_id);
    $stmtSell->execute();

    // Zapytanie dla wiadomości kupowanych (naglowek)
    $queryBuy = "SELECT 
    DISTINCT m.auctionid, m.buyerid, a.firstname,a.lastname, x.title
    FROM message m 
    LEFT JOIN accounts a ON m.buyerid = a.accountid 
    LEFT JOIN auctions x ON m.auctionid = x.auctionid
    WHERE x.accountid = :accountid";
    $stmtBuy = $pdo->prepare($queryBuy);
    $stmtBuy->bindParam(':accountid', $account_id);
    $stmtBuy->execute();

    // Zapytanie dla wiadomości kupowanych (tresc)
    $queryBuyM = "SELECT id, answer, date, description FROM message WHERE auctionid = 1 AND buyerid= 1;";
    $stmtBuyM = $pdo->prepare($queryBuyM);
    $stmtBuyM->execute();


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

            <div class="tab-pane fade show active" id="buy" role="tabpanel" aria-labelledby="messageBuy-tab">
                <div style="width: 20%; float: left;">
                                <table class="table">
                                    <tbody>

                <?php
                // Wyświetlanie wiadomości od zainteresowanych (naglowki)
                while ($rowBuy = $stmtBuy->fetch(PDO::FETCH_ASSOC)) {
                   // $title = $rowBuy[$title];
                echo <<< TABLEMESSLIST
                <tr>
                    <th scope="row p-3">
                    <a class="text-dark" style="text-decoration: none;" href="scripts/mesview.php?aid=$rowBuy[auctionid]&bid=$rowBuy[buyerid]"> 
                        <span>$rowBuy[title]</span><br>
                        <span style="text-decoration: none; font-size: small; ">$rowBuy[firstname] $rowBuy[lastname]</span> 
                    </a>
                    <br>
                    </th>
                </tr>
             TABLEMESSLIST;
                }
                ?>
                </tbody>
             </table>
             </td>
                    <br />
            </div>
            <div id="messview" style="width: 80%; float: left; overflow: hidden; padding: 0em 0em 0em 2em">
                <table class="table table-striped">
                    <tbody>
                <?php
                // Wyświetlanie wiadomości od zainteresowanych (tresc)
                while ($rowBuyM = $stmtBuyM->fetch(PDO::FETCH_ASSOC)) {
                    //print_r($rowBuy);

                echo '<tr>';
                  echo ' <td>';


                        if($rowBuyM["answer"]==1){
                        echo "<div style='text-align: right; font-size: 0.6em;'>".$rowBuyM["date"]."</div>
                                <div style='text-align: right;'>".$rowBuyM["description"]."</div>";
                        }else{
                        echo "<div style='font-size: 0.6em;'>".$rowBuyM["date"]."</div>
                        <div>".$rowBuyM["description"]."</div>";
                        }

                   echo' <br>';
                    echo '</td>';
                echo'</tr>';
                }
                $description='';
                echo <<<SENDMESS
                    <tr>
                        <td>
                        <form method='POST' action='scripts/message.php'>
                            <div class="form-row p-3 text-right">
                                <textarea class="form-control" name='description' id='description' value='description' required>$description</textarea><br>
                                <input type='hidden' name='account_id' value='$account_id'>
                                <a class="btn btn-secondary" type='submit'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                                    </svg>
                                </a>
                            </div>
                        </form>
                        </td>
                    </tr>
                SENDMESS;

                ?>


                    </tbody>
                </table>
            </div>
            </div>


            <div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="messageSell-tab">
                <br />
                <?php
                // Wyświetlanie wiadomości sprzedawanych
                echo "Wiadomości sprzedawanych:<br>";
                while ($rowSell = $stmtSell->fetch(PDO::FETCH_ASSOC)) {
                    echo "Tytuł aukcji: " . $rowSell['title'] . "<br>";
                    echo "Opis wiadomości: " . $rowSell['description'] . "<br><br>";
                }
                ?>
            </div>
        </div>
    </div>

<?php
include_once "constant/footer.php";
?>
