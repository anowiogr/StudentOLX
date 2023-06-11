<?php
require_once 'connect.php';

try {
    // Połączenie z bazą danych
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

// Usunięcie istniejących danych z tabel Polecenie TRUNCATE TABLE usuwa wszystkie rekordy z tabeli, ale zachowuje jej strukturę.
$dbh->exec("TRUNCATE TABLE message_link");
$dbh->exec("TRUNCATE TABLE message");
$dbh->exec("TRUNCATE TABLE auction");
$dbh->exec("TRUNCATE TABLE accounts");
$dbh->exec("TRUNCATE TABLE users");
    // Tworzenie tabel
    $dbh->exec("
        CREATE TABLE IF NOT EXISTS accounts (
            accountid INT NOT NULL,
            userid INT NOT NULL,
            login VARCHAR(100) NOT NULL,
            password VARCHAR(50) NOT NULL,
            account_type INT NOT NULL,
            verified TINYINT(1) NOT NULL,
            PRIMARY KEY (accountid)
        )");

    $dbh->exec("
        CREATE TABLE IF NOT EXISTS auctions (
            auctionid INT NOT NULL,
            accountid INT NOT NULL,
            categoryid INT NOT NULL,
            title VARCHAR(100),
            description TEXT,
            used TINYINT(1),
            private TINYINT(1),
            date_start DATE,
            date_end DATE,
            selled TINYINT(1),
            buyerid INT,
            PRIMARY KEY (auctionid)
        )");

    $dbh->exec("
        CREATE TABLE IF NOT EXISTS category (
            categoryid INT NOT NULL,
            name INT NOT NULL,
            in_treee INT,
            PRIMARY KEY (categoryid)
        )");

    $dbh->exec("
        CREATE TABLE IF NOT EXISTS file_to_auction (
            fileid INT NOT NULL,
            auctionid INT NOT NULL,
            link VARCHAR(200) NOT NULL,
            PRIMARY KEY (fileid)
        )");

    $dbh->exec("
        CREATE TABLE IF NOT EXISTS message (
            id INT NOT NULL,
            mlid INT NOT NULL,
            date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
            description TEXT,
            PRIMARY KEY (id)
        )");

    $dbh->exec("
        CREATE TABLE IF NOT EXISTS message_link (
            mlid INT NOT NULL,
            sellerid INT NOT NULL,
            buyerid INT NOT NULL,
            auctionid INT NOT NULL,
            PRIMARY KEY (mlid)
        )");

    $dbh->exec("
        CREATE TABLE IF NOT EXISTS users (
            userid INT NOT NULL,
            firstname VARCHAR(50),
            lastname VARCHAR(150),
            email VARCHAR(250),
            phone VARCHAR(9),
            address VARCHAR(200),
            codezip VARCHAR(6),
            city VARCHAR(50),
            country VARCHAR(50),
            PRIMARY KEY (userid)
        )");

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
        VALUES (1, 1, 'aragorn', 'password123', 1, 1)
    ");

    // Dodanie aukcji na usługi Aragorna
    $dbh->exec("
        INSERT INTO auction (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
        VALUES (1, 1, 1, 'Przywrócenie królestwa Gondoru', 'Oferuję swoje umiejętności przywódcze w celu odzyskania Gondoru.', 0, 0, '2023-06-10', '2023-06-20', 0)
    ");

    // Dodanie aukcji na sprzedaż Aragorna
    $dbh->exec("
        INSERT INTO auction (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
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
        VALUES (2, 2, 'geralt', 'password123', 1, 1)
    ");

    // Dodanie aukcji na usługi Geralta
    $dbh->exec("
        INSERT INTO auction (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
        VALUES (3, 2, 1, 'Polowanie na potwory', 'Oferuję swoje usługi jako wiedźmin do polowania na potwory.', 0, 0, '2023-06-10', '2023-06-20', 0)
    ");

    // Dodanie aukcji na sprzedaż Geralta
    $dbh->exec("
        INSERT INTO auction (auctionid, accountid, categoryid, title, description, used, private, date_start, date_end, selled)
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

    $dbh->commit();

    echo "Baza danych została zaktualizowana.";
} catch (PDOException $e) {
    echo "Wystąpił błąd: " . $e->getMessage();
}
?>
