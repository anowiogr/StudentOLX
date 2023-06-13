<?php
include_once "constant/header.php";
require "scripts/connect.php";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<body class="d-flex flex-column h-100">
<div class="container prelative">

<?php
    if(isset($_SESSION['info']) && $_SESSION['info']<> null){

        echo "<div class='alert alert-success' role='alert'>$_SESSION[info]</div>";
        $_SESSION['info']=null;
    }
    // Sprawdzenie, czy przesłano ID aukcji
    if (isset($_GET['auction_id'])) {
        $auctionId = $_GET['auction_id'];

        // Pobranie informacji o wybranej aukcji
        $query = "SELECT a.*, u.firstname, u.lastname, u.phone FROM auctions a
                  INNER JOIN accounts u ON a.accountid = u.accountid
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

                    <div class="p-3 mb-2 col-md-6 bg bg-dark text-white">
            <?php
            echo <<< TABLEAUCTIONU
            <table>
            <tr>
                <td>Data wystawienia:</td>
                <td>$auction[date_start]</td>
            </tr>
            <tr>
                <th colspan="2"><h1>$auction[title]</h1></th>
            </tr>
            </table>          
            TABLEAUCTIONU;
            echo '<br><br>';
            echo $auction['description'];
            echo '<br><br>';
            echo "<b>Używany: </b>" . ($auction['used'] ? 'Tak' : 'Nie') . "<br>";
            echo "<b>Prywatny: </b>" . ($auction['private'] ? 'Tak' : 'Nie') . "<br>";
            echo '<br>';
            echo "<b>Sprzedający:</b> " . $auction['firstname'] . " " . $auction['lastname'] . "<br>";
            echo "<b>Telefon:</b> " . ($_SESSION["role"]=="guest" ?  "Zaloguj się aby zobaczyć nr telefonu" : $auction['phone']) ."<br><br>";
            echo "<a class='btn btn-secondary' href='newmessage.php?auction_id=$auctionId'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-send' viewBox='0 0 16 16'>
                        <path d='M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z'/>
                    </svg>
                    Napisz wadomość
                 </a>";
            echo "</div></div>";
            ?>

            <?php

        } else {
            echo "Aukcja o podanym ID nie istnieje.";
        }
    } else {
        // Pobranie wszystkich aukcji z podstawowymi informacjami
        $query = "SELECT a.auctionid, a.title, a.selled, u.firstname, u.lastname, u.city, a.date_start, a.price, a.waluta FROM auctions a
                  INNER JOIN accounts u ON a.accountid = u.accountid WHERE a.selled = 0 AND a.veryfied = 1";
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
                         <h3>$auction[price]</h3>$auction[waluta]
                         </div>
                      <div class="ainfo" >$auction[city],  Data wystawienia: $auction[date_start] </div>   
                    </div>
                    
                
                </div>
            TABLELISTA;

        } echo "<br>";
    }

} catch (PDOException $e) {
    die("Błąd połączenia lub tworzenia bazy danych: " . $e->getMessage());
}
?>


</div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
                </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</div>
</body>
<?php
require 'constant/footer.php';
?>
