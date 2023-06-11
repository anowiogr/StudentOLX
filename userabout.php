<?php
require 'constant/header.php';
require 'scripts/connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pobranie istniejących informacji o użytkowniku
        $query = "SELECT accounts.*, type.type_name, users.*
                  FROM accounts
                  LEFT JOIN type ON accounts.account_type = type.type_id
                  LEFT JOIN users ON accounts.userid = users.userid
                  WHERE accounts.userid = :userid";
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

            // Formularz umożliwiający zmianę danych użytkownika
            echo "<h2>Zmień dane użytkownika</h2>";
            echo "<form method='POST' action=''>";
            echo "<label for='firstname'>Imię:</label>";
            echo "<input type='text' name='firstname' id='firstname' value='" . $user['firstname'] . "' maxlength='50' placeholder='Max 50 znaków' required><br>";
            echo "<label for='lastname'>Nazwisko:</label>";
            echo "<input type='text' name='lastname' id='lastname' value='" . $user['lastname'] . "' maxlength='150' placeholder='Max 150 znaków' required><br>";
            echo "<label for='email'>Email:</label>";
            echo "<input type='email' name='email' id='email' value='" . $user['email'] . "' maxlength='250' placeholder='Wprowadź poprawny email' required><br>";
            echo "<label for='phone'>Telefon:</label>";
            echo "<input type='tel' name='phone' id='phone' value='" . $user['phone'] . "' pattern='[0-9]{9}' placeholder='Numer telefonu (9 cyfr)' required><br>";
            echo "<label for='address'>Adres:</label>";
            echo "<input type='text' name='address' id='address' value='" . $user['address'] . "' maxlength='200' placeholder='Max 200 znaków' required><br>";
            echo "<label for='codezip'>Kod pocztowy:</label>";
            echo "<input type='text' name='codezip' id='codezip' value='" . $user['codezip'] . "' pattern='[0-9]{2}-[0-9]{3}' placeholder='Kod pocztowy (XX-XXX)' required><br>";
            echo "<label for='city'>Miasto:</label>";
            echo "<input type='text' name='city' id='city' value='" . $user['city'] . "' maxlength='50' placeholder='Max 50 znaków' required><br>";
            echo "<label for='country'>Kraj:</label>";
            echo "<input type='text' name='country' id='country' value='" . $user['country'] . "' maxlength='50' placeholder='Max 50 znaków' required><br>";
            echo "<input type='hidden' name='user_id' value='" . $userId . "'>";
            echo "<button type='submit'>Zapisz zmiany</button>";
            echo "</form>";

            // Aktualizacja danych użytkownika
            if (isset($_POST['firstname'])) {
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $codezip = $_POST['codezip'];
                $city = $_POST['city'];
                $country = $_POST['country'];

                $updateQuery = "UPDATE users
                                SET firstname = :firstname,
                                    lastname = :lastname,
                                    email = :email,
                                    phone = :phone,
                                    address = :address,
                                    codezip = :codezip,
                                    city = :city,
                                    country = :country
                                WHERE userid = :userid";

                $updateStatement = $pdo->prepare($updateQuery);
                $updateStatement->bindParam(':firstname', $firstname);
                $updateStatement->bindParam(':lastname', $lastname);
                $updateStatement->bindParam(':email', $email);
                $updateStatement->bindParam(':phone', $phone);
                $updateStatement->bindParam(':address', $address);
                $updateStatement->bindParam(':codezip', $codezip);
                $updateStatement->bindParam(':city', $city);
                $updateStatement->bindParam(':country', $country);
                $updateStatement->bindParam(':userid', $userId);

                $errorMessage = '';

                try {
                    $updateStatement->execute();
                    echo "<p class='success'>Dane zostały zaktualizowane.</p>";
                } catch (PDOException $e) {
                    $errorMessage = $e->getMessage();
                }

                if ($errorMessage !== '') {
                    echo "<p class='error'>Błąd: " . $errorMessage . "</p>";
                }
            }
        } else {
            echo "<p class='error'>Nie znaleziono użytkownika o podanym ID.</p>";
        }
    } else {
        echo "<p class='info'>Wpisz ID użytkownika, aby zmienić dane.</p>";
        echo "<form method='POST' action=''>";
        echo "<label for='user_id'>ID użytkownika:</label>";
        echo "<input type='text' name='user_id' id='user_id' value='" . $userId . "' required>";
        echo "<button type='submit'>Zatwierdź</button>";
        echo "</form>";
    }
} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
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
