<?php
// Plik connect.php

require 'scripts/connect.php';

try {
    // Połączenie z bazą danych MySQL
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

    // Obsługa formularza
    if (isset($_POST['userid'])) {
        $userId = $_POST['userid'];

        $query = "SELECT a.accountid, a.login, a.password, a.account_type, a.verified, u.firstname, u.email, GROUP_CONCAT(DISTINCT auc.title SEPARATOR '<br>') AS auction, GROUP_CONCAT(DISTINCT CONCAT(p.firstname, ' ', p.lastname) SEPARATOR ', ') AS recipients
                  FROM accounts a
                  INNER JOIN users u ON a.userid = u.userid
                  LEFT JOIN auctions auc ON auc.accountid = a.accountid
                  LEFT JOIN message_link ml ON ml.sellerid = a.accountid OR ml.buyerid = a.accountid
                  LEFT JOIN message m ON m.mlid = ml.mlid
                  LEFT JOIN users p ON p.userid = m.receiverid
                  WHERE a.userid = :userId
                  GROUP BY a.accountid, a.login, a.password, a.account_type, a.verified, u.firstname, u.email";
        
        $statement = $dbh->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();

        // Wyświetlenie danych w tabelce
        echo "<table border='1'>
                <tr>
                    <th>Informacje o koncie</th>
                    <th>Informacje o użytkowniku</th>
                    <th>Aukcje</th>
                    <th>Odbiorcy wiadomości</th>
                </tr>";

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>ID konta: " . $row['accountid'] . "<br>";
            echo "Login: " . $row['login'] . "<br>";
            echo "Hasło: " . $row['password'] . "<br>";
            echo "Typ konta: " . $row['account_type'] . "<br>";
            echo "Zweryfikowany: " . ($row['verified'] ? 'Tak' : 'Nie') . "<br></td>";
            echo "<td>Użytkownik: " . $row['login'] . "<br>";
            echo "Email: " . $row['email'] . "<br></td>";
            echo "<td>" . $row['auction'] . "</td>";
            echo "<td>" . $row['recipients'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }

    // Zamknięcie połączenia z bazą danych MySQL
    $dbh = null;
} catch (PDOException $e) {
    die("Wystąpił błąd: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formularz</title>
</head>
<body>
    <form method="POST" action="">
        <label for="userid">ID użytkownika:</label>
        <input type="text" name="userid" id="userid">
        <button type="submit">Pokaż dane</button>
    </form>
</body>
</html>
