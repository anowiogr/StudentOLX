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
    // Sprawdzenie, czy przesłano ID aukcji
    if (isset($_GET['auction_id'])) {
        $auctionId = $_GET['auction_id'];

        // Pobranie informacji o wybranej aukcji
        $query = "SELECT a.*, u.firstname, u.lastname FROM auctions a
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
                    <a href="auction.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="dark" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                        <!--Wróć do widoku wszystkich aukcji-->
                    </a>
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
            echo "</div></div>";
            // Przycisk "Wróć do widoku wszystkich aukcji"

        } else {
            echo "Aukcja o podanym ID nie istnieje.";
        }
    } else {
        // Pobranie wszystkich aukcji z podstawowymi informacjami
        $query = "SELECT a.auctionid, a.title, a.selled, u.firstname, u.lastname, u.city, a.date_start FROM auctions a
                  INNER JOIN accounts u ON a.accountid = u.accountid WHERE a.selled = 0";
        $stmt = $pdo->query($query);
        $auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Wyświetlanie wszystkich aukcji z podstawowymi informacjami
        foreach ($auctions as $auction) {
            echo <<< TABLELISTA
                <div class="row box p-3">
                    <img class="aimg" src="images/nofoto.jpg" />
                    <div class="box-text">
                    <h3>
                        <a class="atitle link-dark" href="auction.php?auction_id=$auction[auctionid]">$auction[title]</a></h3>
                        
                     </div>
                   <div class="ainfo" width="100%">$auction[city],  Data wystawienia: $auction[date_start] </div>
                </div>
                <br>
            TABLELISTA;

        }
    }

} catch (PDOException $e) {
    die("Błąd połączenia lub tworzenia bazy danych: " . $e->getMessage());
}
?>


</div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
                </div>
</div>
</body>
<?php
require 'constant/footer.php';
?>
