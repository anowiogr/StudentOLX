<?php
require_once('connect.php'); // Plik connect.php, który zawiera połączenie do bazy danych

// Funkcja pomocnicza do wykonania zapytania SQL
function executeQuery($query)
{
    global $dbconn;
    $result = pg_query($dbconn, $query);
    if (!$result) {
        die("Błąd zapytania SQL: " . pg_last_error($dbconn));
    }
}

// Funkcja do sprawdzania, czy tabela jest pusta
function isTableEmpty($tableName)
{
    $query = "SELECT EXISTS (SELECT 1 FROM $tableName LIMIT 1)";
    $result = pg_query($query);
    $row = pg_fetch_row($result);
    return $row[0] === 'f';
}

// Funkcja do opróżniania tabeli
function truncateTable($tableName)
{
    $query = "TRUNCATE TABLE $tableName";
    executeQuery($query);
}

// Pytanie o wypełnienie tabel danymi
$fillTables = readline("Czy chcesz wypełnić tabele danymi? (tak/nie): ");

if ($fillTables === 'tak') {
    // Sprawdzanie, czy tabele są puste
    $usersEmpty = isTableEmpty('public.users');
    $auctionsEmpty = isTableEmpty('public.auction');
    $messagesEmpty = isTableEmpty('public.message');

    // Pytanie o opróżnienie tabel
    if (!$usersEmpty || !$auctionsEmpty || !$messagesEmpty) {
        $clearTables = readline("Jedna lub więcej tabel nie jest pusta. Czy chcesz opróżnić tabele i załadować dane na nowo? (tak/nie): ");
        if ($clearTables === 'tak') {
            // Opróżnianie tabel
            if (!$usersEmpty) {
                truncateTable('public.users');
            }
            if (!$auctionsEmpty) {
                truncateTable('public.auction');
            }
            if (!$messagesEmpty) {
                truncateTable('public.message');
                truncateTable('public.message_link');
            }
        } else {
            echo "Nie wykonano żadnych zmian w bazie danych.";
            exit();
        }
    }

    // Generowanie przykładowych danych użytkowników
    $users = [
        ['Frodo', 'Baggins', 'frodo@example.com', '123456789', 'Shire', '12345', 'Hobbiton', 'Middle-earth'],
        ['Aragorn', 'Elessar', 'aragorn@example.com', '987654321', 'Rivendell', '54321', 'Gondor', 'Middle-earth'],
        ['Gandalf', '', 'gandalf@example.com', '555555555', 'Unknown', '99999', 'Unknown', 'Middle-earth'],
        ['Legolas', 'Greenleaf', 'legolas@example.com', '111111111', 'Woodland Realm', '77777', 'Mirkwood', 'Middle-earth'],
        ['Gollum', '', 'gollum@example.com', '222222222', 'Caves', '66666', 'Misty Mountains', 'Middle-earth']
    ];

    // Wypełnianie tabeli 'users'
    foreach ($users as $index => $user) {
        $userid = $index + 1;
        $username = $user[0];
        $lastname = $user[1];
        $email = $user[2];
        $phone = $user[3];
        $address = $user[4];
        $zipcode = $user[5];
        $city = $user[6];
        $country = $user[7];
        $query = "INSERT INTO public.users (userid, username, lastname, email, phone, address, zipcode, city, country) VALUES ($userid, '$username', '$lastname', '$email', '$phone', '$address', '$zipcode', '$city', '$country')";
        executeQuery($query);
    }

    // Wypełnianie tabeli 'auction'
    $auctions = [
        ['Frodo', 'Pierścień', '2023-03-01'],
        ['Aragorn', 'Miecz Narsil', '2023-03-02'],
        ['Gandalf', 'Kij Gandalfa', '2023-03-03'],
        ['Legolas', 'Łuk elficki', '2023-03-04'],
        ['Gollum', 'Pierścień', '2023-03-05']
    ];

    foreach ($auctions as $index => $auction) {
        $auctionid = $index + 1;
        $sellerid = $index + 1;
        $title = $auction[1];
        $dateStart = $auction[2];
        $dateEnd = date('Y-m-d', strtotime($dateStart . ' + 7 days')); // Aukcje trwają przez 7 dni
        $query = "INSERT INTO public.auction (auctionid, accountid, title, date_start, date_end) VALUES ($auctionid, $sellerid, '$title', '$dateStart', '$dateEnd')";
        executeQuery($query);
    }

    // Generowanie przykładowych wiadomości
    $messages = [
        ['Frodo', 'Aragorn', 'Witam! Czy byłbyś zainteresowany kupnem pierścienia?'],
        ['Aragorn', 'Frodo', 'Dzień dobry! Jaki jest stan pierścienia?'],
        ['Gandalf', 'Legolas', 'Witaj Legolasie! Czy nadal sprzedajesz swój łuk elficki?'],
        ['Legolas', 'Gandalf', 'Cześć Gandalfie! Tak, łuk elficki jest wciąż dostępny.'],
        ['Gollum', 'Frodo', 'Chcę, muszę mieć ten pierścień!'],
        ['Frodo', 'Gollum', 'Przepraszam, ale pierścień jest już sprzedany.'],
    ];

    // Wypełnianie tabeli 'message' i 'message_link'
    $messageId = 1;
    foreach ($messages as $message) {
        $seller = $message[0];
        $buyer = $message[1];
        $messageText = $message[2];

        $query = "INSERT INTO public.message (id, mlid, date, description) VALUES ($messageId, $messageId, '2023-03-01', '$messageText')";
        executeQuery($query);

        $sellerId = array_search($seller, array_column($users, 0)) + 1;
        $buyerId = array_search($buyer, array_column($users, 0)) + 1;
        $query = "INSERT INTO public.message_link (id, aid, sellerid, buyerid) VALUES ($messageId, 1, $sellerId, $buyerId)";
        executeQuery($query);

        $messageId++;
    }

    echo "Dane zostały załadowane do tabel.";
} else {
    echo "Nie wykonano żadnych zmian w bazie danych.";
}
?>
