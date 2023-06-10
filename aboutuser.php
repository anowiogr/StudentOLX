<?php
// Plik connect.php

$dbconn = pg_connect("dbname=localhost port=5432 dbname=studentolx user=postgres password=P05tGr3s");

if (!$dbconn) {
    die("Błąd połączenia z bazą danych: " . pg_last_error());
}

// Pobranie danych konta zalogowanego użytkownika (na podstawie ID użytkownika)
$userId = 123; // ID użytkownika (przykładowe)

$query = "SELECT * FROM public.accounts WHERE userid = $userId";
$result = pg_query($dbconn, $query);

if (!$result) {
    die("Błąd zapytania do bazy danych: " . pg_last_error());
}

// Wyświetlenie danych konta zalogowanego użytkownika
while ($row = pg_fetch_assoc($result)) {
    echo "ID konta: " . $row['accountid'] . "<br>";
    echo "ID użytkownika: " . $row['userid'] . "<br>";
    echo "Login: " . $row['login'] . "<br>";
    echo "Hasło: " . $row['password'] . "<br>";
    echo "Typ konta: " . $row['account_type'] . "<br>";
    echo "Zweryfikowany: " . ($row['veryfied'] ? 'Tak' : 'Nie') . "<br>";
    echo "<br>";
}

// Zamknięcie połączenia z bazą danych
pg_close($dbconn);
?>
