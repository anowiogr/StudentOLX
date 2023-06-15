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


    // Zapytanie dla wiadomości (tresc)
    $query = "SELECT id, answer, date, description FROM message 
                        WHERE auctionid = :auctionid AND buyerid= :buyerid;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':auctionid', $_GET['aid']);
    $stmt->bindParam(':buyerid', $_GET['bid']);
    $stmt->execute();

} catch (PDOException $e) {
    echo "Błąd połączenia lub aktualizacji bazy danych: " . $e->getMessage();
}
?>
<div class="row col-md-1">
    <button style="border: 0px;" onclick="goBack()">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="dark" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
        </svg>
        <!--Wróć do widoku wszystkich aukcji-->
    </button>
</div>
                <div id="messview">

                <table class="table table-striped">
                    <tbody>

                <?php
                // Wyświetlanie wiadomości od zainteresowanych (tresc)
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    //print_r($rowBuy);

                    echo '<tr>';
                    echo ' <td>';


                    if($row["answer"]==1){
                        echo "<div style='text-align: right; font-size: 0.6em;'>".$row["date"]."</div>
                                <div style='text-align: right;'>".$row["description"]."</div>";
                    }else{
                        echo "<div style='font-size: 0.6em;'>".$row["date"]."</div>
                        <div>".$row["description"]."</div>";
                    }

                    echo' <br>';
                    echo '</td>';
                    echo'</tr>';
                }
                $description='';
                if(!isset($_GET['a']) || $_GET['a'] == null){$_GET['a']=2;}
                echo <<<SENDMESS
                    <tr>
                        <td>
                        <form method='POST' action='scripts/mesview.php'>
                            <div class="form-row p-3" >
                                <div style="width: 90%; float: left;">
                                    <textarea class="form-control" name='description' id='description' value='$description' required>$description</textarea><br>
                                    <input type='hidden' name='auctionid' value='$_GET[aid]'>
                                    <input type='hidden' name='buyerid' value='$_GET[bid]'>
                                    <input type='hidden' name='answer' value='$_GET[a]'>
                                </div>
                               <div style=" overflow: hidden; float: right;">
                                    <button class="btn btn-secondary">
                                    <a type='submit'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                                        </svg>
                                    </a>
                                    </button>
                               </div>
                            </div>
                        </form>
                        </td>
                    </tr>
                SENDMESS;
?>
                    </tbody>
                </table>
                </div>
                    <?php
                require 'constant/footer.php';
                ?>

