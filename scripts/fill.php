<?php
require_once 'connect.php';

try {
    // Połączenie z bazą danych
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

    // Usunięcie istniejących danych z tabel
    $tables = ['message_link', 'message', 'auctions', 'accounts', 'users'];
    foreach ($tables as $table) {
        $dbh->exec("DELETE FROM $table");
    }

    // Dodanie postaci ze świata LOTR
    $dbh->beginTransaction();

    // Dodanie użytkownika Aragorn
    $dbh->exec("
        INSERT INTO users (userid, firstname, lastname, email, phone, address, codezip, city, country)
        VALUES (1, 'Aragorn', 'Elessar', 'aragorn@example.com', '123456789', 'Middle-earth', '12345', 'Minas Tirith', 'Gondor')
    ");

    // Dodanie konta Aragorna
    $dbh->exec("
        INSERT INTO accounts (accountid, userid, login, password, account_type, verified)
        VALUES (1, 1, 'aragorn', 'password123', 101, 1)
    ");

    // Dodanie aukcji na usługi Aragorna
    $dbh->exec("
        INSERT INTO auctions (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
        VALUES (1, 1, 1, 'Przywrócenie królestwa Gondoru', 'Oferuję swoje umiejętności przywódcze w celu odzyskania Gondoru.', 0, 0, '2023-06-10', '2023-06-20', 0)
    ");

    // Dodanie aukcji na sprzedaż Aragorna
    $dbh->exec("
        INSERT INTO auctions (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
        VALUES (2, 1, 2, 'Miecz Narsil', 'Sprzedaję legendarny miecz Narsil, którym pokonałem Saurona.', 1, 1, '2023-06-10', '2023-06-15', 0)
    ");

    // Dodanie konwersacji Aragorna z innymi postaciami
    $dbh->exec("
        INSERT INTO message_link (mlid, sellerid, buyerid, auctionid)
        VALUES (1, 1, 3, 1)
    ");

    $dbh->exec("
        INSERT INTO message_link (mlid, sellerid, buyerid, auctionid)
        VALUES (2, 1, 4, 2)
    ");

    $dbh->exec("
        INSERT INTO message (id, mlid, date, description)
        VALUES (1, 1, '2023-06-10 10:30:00', 'Czy oferta dotyczy również transportu?')
    ");

    $dbh->exec("
        INSERT INTO message (id, mlid, date, description)
        VALUES (2, 1, '2023-06-10 11:15:00', 'Tak, transport jest wliczony w cenę.')
    ");

    $dbh->exec("
        INSERT INTO message (id, mlid, date, description)
        VALUES (3, 2, '2023-06-12 14:20:00', 'Czy miecz posiada jakiś certyfikat autentyczności?')
    ");

    $dbh->exec("
        INSERT INTO message (id, mlid, date, description)
        VALUES (4, 2, '2023-06-12 15:45:00', 'Tak, miecz posiada certyfikat autentyczności od elfów z Rivendell.')
    ");

    $dbh->commit();

    // Dodanie postaci ze świata Wiedźmina
    $dbh->beginTransaction();

    // Dodanie użytkownika Geralt
    $dbh->exec("
        INSERT INTO users (userid, firstname, lastname, email, phone, address, codezip, city, country)
        VALUES (2, 'Geralt', 'z Rivii', 'geralt@example.com', '987654321', 'Kaer Morhen', '54321', 'Rivia', 'Redania')
    ");

    // Dodanie konta Geralta
    $dbh->exec("
        INSERT INTO accounts (accountid, userid, login, password, account_type, verified)
        VALUES (2, 2, 'geralt', 'password123', 010, 1)
    ");

    // Dodanie aukcji na usługi Geralta
    $dbh->exec("
        INSERT INTO auctions (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
        VALUES (3, 2, 1, 'Polowanie na potwory', 'Oferuję swoje usługi jako wiedźmin do polowania na potwory.', 0, 0, '2023-06-10', '2023-06-20', 0)
    ");

    // Dodanie aukcji na sprzedaż Geralta
    $dbh->exec("
        INSERT INTO auctions (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
        VALUES (4, 2, 2, 'Miecz srebrny', 'Sprzedaję używany srebrny miecz wiedźmiński.', 1, 1, '2023-06-10', '2023-06-15', 0)
    ");

    // Dodanie konwersacji Geralta z innymi postaciami
    $dbh->exec("
        INSERT INTO message_link (mlid, sellerid, buyerid, auctionid)
        VALUES (3, 2, 1, 3)
    ");

    $dbh->exec("
        INSERT INTO message_link (mlid, sellerid, buyerid, auctionid)
        VALUES (4, 2, 3, 4)
    ");

    $dbh->exec("
        INSERT INTO message (id, mlid, date, description)
        VALUES (5, 3, '2023-06-10 10:30:00', 'Czy oferujesz także szkolenia dla początkujących wiedźminów?')
    ");

    $dbh->exec("
        INSERT INTO message (id, mlid, date, description)
        VALUES (6, 3, '2023-06-10 11:15:00', 'Tak, prowadzę szkolenia dla początkujących wiedźminów.')
    ");

    $dbh->exec("
        INSERT INTO message (id, mlid, date, description)
        VALUES (7, 4, '2023-06-12 14:20:00', 'Czy miecz posiada jakieś wady?')
    ");

    $dbh->exec("
        INSERT INTO message (id, mlid, date, description)
        VALUES (8, 4, '2023-06-12 15:45:00', 'Miecz jest w doskonałym stanie i nie posiada wad.')
    ");

    // Dodanie postaci ze świata LOTR


// Dodanie użytkownika Frodo
$dbh->exec("
    INSERT INTO users (userid, firstname, lastname, email, phone, address, codezip, city, country)
    VALUES (3, 'Frodo', 'Baggins', 'frodo@example.com', '987654321', 'The Shire', '54321', 'Hobbiton', 'The Shire')
");

// Dodanie konta Frodo
$dbh->exec("
    INSERT INTO accounts (accountid, userid, login, password, account_type, verified)
    VALUES (3, 3, 'frodo', 'password123', 002, 1)
");

// Dodanie aukcji na usługi Frodo
$dbh->exec("
    INSERT INTO auctions (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
    VALUES (5, 3, 1, 'Przewiezienie Pierścienia', 'Oferuję usługę przewiezienia Pierścienia do Mordoru.', 0, 0, '2023-06-10', '2023-06-20', 0)
");

// Dodanie aukcji na sprzedaż Frodo
$dbh->exec("
    INSERT INTO auctions (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
    VALUES (6, 3, 2, 'Księga Mazarbul', 'Sprzedaję starożytną Księgę Mazarbul znalezioną w Morii.', 1, 1, '2023-06-10', '2023-06-15', 0)
");

// Dodanie konwersacji Frodo z innymi postaciami
$dbh->exec("
    INSERT INTO message_link (mlid, sellerid, buyerid, auctionid)
    VALUES (5, 3, 1, 5)
");

$dbh->exec("
    INSERT INTO message_link (mlid, sellerid, buyerid, auctionid)
    VALUES (6, 3, 2, 6)
");

$dbh->exec("
    INSERT INTO message (id, mlid, date, description)
    VALUES (9, 5, '2023-06-10 10:30:00', 'Czy oferujesz także usługę eskorty?')
");

$dbh->exec("
    INSERT INTO message (id, mlid, date, description)
    VALUES (10, 5, '2023-06-10 11:15:00', 'Tak, mogę zapewnić eskortę podczas podróży.')
");

$dbh->exec("
    INSERT INTO message (id, mlid, date, description)
    VALUES (11, 6, '2023-06-12 14:20:00', 'Czy Księga Mazarbul jest w pełni czytelna?')
");

$dbh->exec("
    INSERT INTO message (id, mlid, date, description)
    VALUES (12, 6, '2023-06-12 15:45:00', 'Księga Mazarbul jest w dobrym stanie, ale niektóre strony są mocno zniszczone.')
");

$dbh->commit();

// Dodanie postaci ze świata Wiedźmina
$dbh->beginTransaction();

// Dodanie użytkownika Ciri
$dbh->exec("
    INSERT INTO users (userid, firstname, lastname, email, phone, address, codezip, city, country)
    VALUES (4, 'Ciri', 'z Cintry', 'ciri@example.com', '123456789', 'Cintra', '12345', 'Cintra', 'Nilfgaard')
");

// Dodanie konta Ciri
$dbh->exec("
    INSERT INTO accounts (accountid, userid, login, password, account_type, verified)
    VALUES (4, 4, 'ciri', 'password123', 002, 1)
");

// Dodanie aukcji na usługi Ciri
$dbh->exec("
    INSERT INTO auctions (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
    VALUES (7, 4, 1, 'Trening walki', 'Oferuję trening walki z mieczem i magii.', 0, 0, '2023-06-10', '2023-06-20', 0)
");

// Dodanie aukcji na sprzedaż Ciri
$dbh->exec("
    INSERT INTO auctions (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
    VALUES (8, 4, 2, 'Pierścień z Cintry', 'Sprzedaję magiczny pierścień z Cintry.', 1, 1, '2023-06-10', '2023-06-15', 0)
");

// Dodanie konwersacji Ciri z innymi postaciami
$dbh->exec("
    INSERT INTO message_link (mlid, sellerid, buyerid, auctionid)
    VALUES (7, 4, 2, 7)
");

$dbh->exec("
    INSERT INTO message_link (mlid, sellerid, buyerid, auctionid)
    VALUES (8, 4, 3, 8)
");

$dbh->exec("
    INSERT INTO message (id, mlid, date, description)
    VALUES (13, 7, '2023-06-10 10:30:00', 'Czy oferujesz także szkolenia magiczne?')
");

$dbh->exec("
    INSERT INTO message (id, mlid, date, description)
    VALUES (14, 7, '2023-06-10 11:15:00', 'Tak, prowadzę szkolenia z zaklęć i magii.')
");

$dbh->exec("
    INSERT INTO message (id, mlid, date, description)
    VALUES (15, 8, '2023-06-12 14:20:00', 'Czy pierścień ma jakieś specjalne właściwości?')
");

$dbh->exec("
    INSERT INTO message (id, mlid, date, description)
    VALUES (16, 8, '2023-06-12 15:45:00', 'Pierścień posiada zdolność niewidzialności.')
");

$dbh->commit();

    echo "Baza danych została zaktualizowana.";
} catch (PDOException $e) {
    echo "Wystąpił błąd: " . $e->getMessage();
}
?>
