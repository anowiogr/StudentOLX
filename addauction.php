<?php
require 'constant/header.php';
require 'scripts/connect.php';

$used = false;
$private = false;


    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }


$account_id = $_SESSION["logged"]["account_id"];


?>
         <form method='POST' action='scripts/newauction.php'>
         <table class="table">
            <tbody>
            <tr>
                <td><label for='title'>Tytuł:</label></td>
                <td><input class="form-control" type='text' name='title' id='title' required></td>
            </tr>
            <tr>
                <td><label for='categoryid'>Kategoria:</label></td>
                <td>
                    <select class="form-control" name='categoryid' id='categoryid' required>
                    <?php
                      $query = "SELECT * FROM category";
                      $stmt = $pdo->query($query);
                      $category1 = $stmt->fetchAll();
                      //print_r($category);
                      foreach ($category1 as $category){
                        echo "<option value='$category[categoryid]'>$category[name]</option>";
                      }
                      ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for='description'>Opis:</label></td>
                <td><textarea class="form-control" name='description' id='description' required></textarea></td>
            </tr>
            <tr>
                <td><label class="form-check-label" for='used'>Używany: </label></td>
                <td><input class="form-check-input" type='checkbox' name='used' id='used' > </td>
            </tr>
            <tr>
                <td><label class="form-check-label"for='private'>Prywatny:</label></td>
                <td><input class="form-check-input" type='checkbox' name='private' id='private' ></td>
            </tr>
            <tr>
                <td colspan="2">Cena:</td>
            </tr>

            <tr>
                <td><input class="form-control" type='text' pattern="\d*" name='price' id='price' required></td>
                <td><select class="form-control" name='currencyid' id='currencyid' required>
                        <?php
                        $query = "SELECT * FROM currency";
                        $stmt = $pdo->query($query);
                        $currency1 = $stmt->fetchAll();
                        foreach ($currency1 as $currency){
                            echo "<option value='$currency[currencyid]'>$currency[currency_name]</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                 <input type='hidden' name='account_id' <?php echo "value=' $account_id '";?>> <!-- ID użytkownika, dla którego dodawane jest ogłoszenie-->
                 <button class="btn btn-secondary" type='submit' name='action' value='add'>Dodaj</button>
                </td>
            </tr>

         </tbody>
         </table>
        </form>



<?php
include_once "constant/footer.php";
?>
