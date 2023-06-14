<?php
require 'constant/header.php';
require 'scripts/connect.php';

$title = '';
$description = '';
$used = false;
$private = false;
$dateStart = date('Y-m-d');
$dateEnd = date('Y-m-d', strtotime('+2 weeks'));
$account_id = $_SESSION["logged"]["account_id"];
//print_r($_SESSION["logged"]);

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }

    // Wyświetlanie formularza dodawania nowego ogłoszenia
    echo <<<TABLEFORM
         <form method='POST' action='scripts/newauction.php'>
          <div class="form-row p-3">
         <label for='title'>Tytuł:</label><br>
         <input class="form-control" type='text' name='title' id='title' value='$title' required><br>
    
         <label for='description'>Opis:</label><br>
         <textarea class="form-control" name='description' id='description' required>$description</textarea><br>
         
         <label class="form-check-label" for='used'>Używany: </label>
         <input class="form-check-input" type='checkbox' name='used' id='used' <?php echo "($used ? 'checked' : '')"; ?> <br>
    
         <label class="form-check-label"for='private'>Prywatny:</label>
         <input class="form-check-input" type='checkbox' name='private' id='private' <?php echo "($private ? 'checked' : '')"; ?> <br>
    
         <input type='hidden' name='account_id' value='$account_id'> <!-- ID użytkownika, dla którego dodawane jest ogłoszenie-->
            <br>
         <button class="btn btn-secondary" type='submit' name='action' value='add'>Dodaj</button>
         </div>
        </form>
    TABLEFORM;


?>


<?php
include_once "constant/footer.php";
?>
