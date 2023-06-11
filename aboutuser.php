
	<?php
	require 'constant/header.php';
require 'scripts/connect.php';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_POST['user_id'];

        $query = "SELECT accounts.*, type.type_name
                  FROM accounts
                  LEFT JOIN type ON accounts.account_type = type.type_id
                  WHERE userid = :userid";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':userid', $userId);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "<h2>Informacje o użytkowniku</h2>";
            echo "<p>ID: " . $user['accountid'] . "</p>";
            echo "<p>Login: " . $user['login'] . "</p>";
            echo "<p>Typ konta: " . $user['type_name'] . "</p>";
            echo "<p>Zweryfikowany: " . ($user['verified'] ? 'Tak' : 'Nie') . "</p>";
            // Wyświetlanie pozostałych informacji dotyczących użytkownika
            // ...
        } else {
            echo "Użytkownik o podanym ID nie został znaleziony.";
        }
    }
} catch (PDOException $e) {
    die("Błąd połączenia lub tworzenia bazy danych: " . $e->getMessage());
}
?>
<h2>Wyszukaj użytkownika</h2>
<form method="POST" action="">
    <label for="user_id">ID użytkownika:</label>
    <input type="text" name="user_id" id="user_id" required>
    <button type="submit">Szukaj</button>
</form>
<?
require 'constant/footer.php';
?>
