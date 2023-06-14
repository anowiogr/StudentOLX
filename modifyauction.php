<?php
require 'constant/header.php';
require 'scripts/connect.php';
?>
<body class="d-flex flex-column h-100">

<div class="container prelative">
<?php

$account_id = $_SESSION["logged"]["account_id"];
//print_r($_SESSION["logged"]);


$auction_id = $_GET['auction_id'];

 try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



     $query = "SELECT * FROM auctions WHERE auctionid = :id";
     $statement = $pdo->prepare($query);
     $statement->bindParam(':id', $auction_id);
     $statement->execute();

     $auction = $statement->fetch(PDO::FETCH_ASSOC);

       /*
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
*/
    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }

    if($auction) {
        // Wyświetlanie formularza
        echo <<<TABLEFORM
         <form method='POST' action='scripts/modify.php'>
          <div class="form-row p-3">
         <label for='title'>Tytuł:</label><br>
         <input class="form-control"type='text' name='title' id='title' value='$auction[title]' required><br>
    
         <label for='description'>Opis:</label><br>
         <textarea class="form-control" name='description' id='description' required>$auction[description]</textarea><br>
         
         <label class="form-check-label" for='used'>Używany: </label>
         <input class="form-check-input" type='checkbox' name='used' value="$auction[used]"  id='used' <?php echo "($auction[used] ? 'checked' : '')"; ?> <br>
    
         <label class="form-check-label"for='private'>Prywatny:</label>
         <input class="form-check-input" type='checkbox' name='private' id='priv' value="$auction[private]" <?php echo "($auction[private] ? 'checked' : '')"; ?> <br>
    
         <input type='hidden' name='account_id' value='$account_id'> <!-- ID użytkownika, dla którego dodawane jest ogłoszenie-->
         <input type='hidden' name='auction_id' value='$auction_id'>
            <br>
         <button class="btn btn-secondary" type='submit'>Zmień</button>
         </div>
        </form>
    TABLEFORM;
    }

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>


</div>
</body>
<?php
include_once "constant/footer.php";
?>
