<?php
require 'constant/header.php';
require 'scripts/connect.php';


$account_id = $_SESSION["logged"]["account_id"];
//print_r($_SESSION["logged"]);


$auction_id = $_GET['auction_id'];

 try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



     $query = "SELECT * FROM auctions a LEFT JOIN currency c ON a.currencyid = c.currencyid WHERE auctionid = :id";
     $statement = $pdo->prepare($query);
     $statement->bindParam(':id', $auction_id);
     $statement->execute();

     $auction = $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Błąd połączenia: " . $e->getMessage();
    }

    if($auction) {
        // Wyświetlanie formularza
?>
        <form method='POST' action='scripts/modify.php'>
            <table class="table">
                <tbody>
                <tr>
                    <td><label for='title'>Tytuł:</label></td>
                    <td><input class="form-control" type='text' name='title' id='title' <?php echo"value='$auction[title]'";?>  required></td>
                </tr>
                <tr>
                    <td><label for='categoryid'>Kategoria:</label></td>
                    <td>
                        <select class="form-control" name='categoryid' id='categoryid' required>
                            <?php
                            $query = "SELECT * FROM category";
                            $stmt = $pdo->query($query);
                            $category1 = $stmt->fetchAll();
                            foreach ($category1 as $category){
                                if($category["categoryid"]==$auction["categoryid"]){
                                    echo "<option selected='selected' value='$category[categoryid]'>$category[name]</option>";
                                }else{
                                    echo "<option value='$category[categoryid]'>$category[name]</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for='description'>Opis:</label></td>
                    <td><textarea class="form-control" name='description' id='description' required><?php echo $auction["description"];?></textarea></td>
                </tr>
                <tr>
                    <td><label class="form-check-label" for='used'>Używany: </label></td>
                    <td><input class="form-check-input" type='checkbox' name='used' id='used' <?php if($auction["used"]) {echo "checked";} ?> > </td>
                </tr>
                <tr>
                    <td><label class="form-check-label"for='private'>Prywatny:</label></td>
                    <td><input class="form-check-input" type='checkbox' name='private' id='private' <?php if($auction["private"]) {echo "checked";} ?> ></td>
                </tr>
                <tr>
                    <td colspan="2">Cena:</td>
                </tr>

                <tr>
                    <td><input class="form-control" type='text' pattern="\d*" name='price' id='price' <?php echo"value='$auction[price]'";?> required></td>
                    <td><select class="form-control" name='currencyid' id='currencyid' required>
                            <?php
                            $query = "SELECT * FROM currency";
                            $stmt = $pdo->query($query);
                            $currency1 = $stmt->fetchAll();
                            foreach ($currency1 as $currency){
                                if($currency["currencyid"]==$auction["currencyid"]){
                                    echo "<option selected='selected' value='$currency[currencyid]'>$currency[currency_name]</option>";
                                }else{
                                echo "<option value='$currency[currencyid]'>$currency[currency_name]</option>";
                                }
                            }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type='hidden' name='auctionid' <?php echo "value=' $auction[auctionid] '";?>> <!-- ID użytkownika, dla którego dodawane jest ogłoszenie-->
                        <button class="btn btn-secondary" type='submit' >Zmień</button>
                    </td>
                </tr>

                </tbody>
            </table>
        </form>
<?php
include_once "constant/footer.php";
?>
