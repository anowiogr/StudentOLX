<?php
require 'constant/header.php';
require 'scripts/connect.php';
?>
    <table class="table">
        <tr>
            <td>
                <div class="row col-md-1">
                    <button style="border: 0px;" onclick="goBack()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="dark" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                        <!--Wróć do widoku wszystkich aukcji-->
                    </button>
                </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
<?php
    if(!isset($_SESSION["logged"]["account_id"]) || $_SESSION["logged"]["account_id"]==null){
        header('Location: index.php');
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $account_id=$_SESSION["logged"]["account_id"];
        $auctionid=$_GET['auction_id'];
        $description='';

        $query = "SELECT title FROM auctions WHERE auctionid = :auctionId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':auctionId', $auctionid, PDO::PARAM_INT);
        $stmt->execute();
        $auction = $stmt->fetch(PDO::FETCH_ASSOC);

        //print_r($_SESSION["logged"]["account_id"]);
    if($auction){
    // Wyświetlanie formularza dodawania nowego ogłoszenia
    echo <<<TABLEFORM
         <form method='POST' action='scripts/message.php'>
          <div class="form-row p-3">
         <label for='title'>Tytuł:</label><br>
         <input class="form-control" type='text' name='title' id='title' value='$auction[title]' disabled><br>
    
         <label for='tresc'>Treść:</label><br>
         <textarea class="form-control" name='description' id='description' value='description' required>$description</textarea><br>

         <input type='hidden' name='account_id' value='$account_id'>
         <input type='hidden' name='auction_id' value='$auctionid'>
            <br>
         <button class="btn btn-secondary" type='submit'>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                </svg>
                Wyślij
         </button>
         </div>
        </form>
    TABLEFORM;
    }

 } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }

?>
            </td>
    </tr>
    </table>
<?php
include_once "constant/footer.php";
?>
