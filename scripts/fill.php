<?php
require 'connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Usuwanie istniejącej bazy danych
    $dropDatabase = "DROP DATABASE IF EXISTS $dbname";
    $pdo->exec($dropDatabase);

    // Tworzenie nowej bazy danych
    $createDatabase = "CREATE DATABASE $dbname";
    $pdo->exec($createDatabase);
    $pdo->exec("USE $dbname");

    // Tworzenie tabeli type
    $createTypeTable = "CREATE TABLE IF NOT EXISTS type (
        type_id VARCHAR(3) NOT NULL PRIMARY KEY,
        type_name VARCHAR(20) NOT NULL
    )";
    $pdo->exec($createTypeTable);

    // Wstawianie danych do tabeli type
    $insertTypes = "INSERT INTO type (type_id, type_name)
                    VALUES
                        ('222', 'user'),
                        ('101', 'mod'),
                        ('191', 'admin')";
    $pdo->exec($insertTypes);

    // Tworzenie tabeli accounts
    $createAccountsTable = "CREATE TABLE IF NOT EXISTS accounts (
        accountid INT NOT NULL AUTO_INCREMENT,
        login VARCHAR(100) NOT NULL,
        password VARCHAR(50) NOT NULL,
        account_type VARCHAR(3) NOT NULL DEFAULT '222',
        verified TINYINT(1) NOT NULL,
        firstname VARCHAR(50),
        lastname VARCHAR(150),
        email VARCHAR(250),
        phone VARCHAR(9),
        address VARCHAR(200),
        codezip VARCHAR(6),
        city VARCHAR(50),
        country VARCHAR(50),
        PRIMARY KEY (accountid)
    )";
    $pdo->exec($createAccountsTable);

    // Tworzenie tabeli auctions
    $createAuctionTable = "CREATE TABLE IF NOT EXISTS auctions (
        auctionid INT NOT NULL AUTO_INCREMENT,
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
    )";
    $pdo->exec($createAuctionTable);

    // Tworzenie tabeli category
    $createCategoryTable = "CREATE TABLE IF NOT EXISTS category (
        categoryid INT NOT NULL AUTO_INCREMENT,
        name INT NOT NULL,
        in_tree INT,
        PRIMARY KEY (categoryid)
    )";
    $pdo->exec($createCategoryTable);

    // Tworzenie tabeli file_to_auction
    $createFileToAuctionTable = "CREATE TABLE IF NOT EXISTS file_to_auction (
        file_id INT(11) NOT NULL AUTO_INCREMENT,
        auction_id INT(11) NOT NULL,
        filename VARCHAR(255) NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        PRIMARY KEY (file_id),
        FOREIGN KEY (auction_id) REFERENCES auctions(auctionid) ON DELETE CASCADE
    )";
    $pdo->exec($createFileToAuctionTable);

    // Tworzenie tabeli message
    $createMessageTable = "CREATE TABLE IF NOT EXISTS message (
        id INT NOT NULL AUTO_INCREMENT,
        mlid INT NOT NULL,
        date DATE DEFAULT CURRENT_TIMESTAMP NOT NULL,
        description TEXT,
        PRIMARY KEY (id)
    )";
    $pdo->exec($createMessageTable);

    // Tworzenie tabeli message_link
    $createMessageLinkTable = "CREATE TABLE IF NOT EXISTS message_link (
        mlid INT NOT NULL AUTO_INCREMENT,
        sellerid INT NOT NULL,
        buyerid INT NOT NULL,
        auctionid INT NOT NULL,
        PRIMARY KEY (mlid),
        FOREIGN KEY (sellerid) REFERENCES accounts(accountid),
        FOREIGN KEY (buyerid) REFERENCES accounts(accountid),
        FOREIGN KEY (auctionid) REFERENCES auctions(auctionid) ON DELETE CASCADE
    )";
    $pdo->exec($createMessageLinkTable);

    // Wstawianie danych do tabeli accounts
    $insertAccounts = "INSERT INTO accounts (login, password, account_type, verified, firstname, lastname, email, phone, address, codezip, city, country)
                    VALUES
                        ('Gandalf', 'password1', '101', 1, 'Gandalf', 'Szary', 'gandalf@example.com', '123456789', 'Mroczna Dolina 1', '12-345', 'Minas Tirith', 'Gondor'),
                        ('Frodo', 'password2', '222', 1, 'Frodo', 'Baggins', 'frodo@example.com', '987654321', 'Hobbiton 2', '98-765', 'Shire', 'Middle-earth'),
                        ('Yennefer', 'password3', '222', 1, 'Yennefer', 'z Vengerbergu', 'yennefer@example.com', '555555555', 'Wyzima 3', '54-321', 'Redania', 'Księstwo Redanii'),
                        ('Geralt', 'password4', '222', 1, 'Geralt', 'z Rivii', 'geralt@example.com', '777777777', 'Kaer Morhen 4', '01-234', 'Temeria', 'Królestwo Temerii')";
    $pdo->exec($insertAccounts);

    // Wstawianie danych do tabeli auctions
    $insertAuctions = "INSERT INTO auctions (accountid, categoryid, title, description, used, private, date_start, date_end, selled, buyerid)
                    VALUES
                        (1, 1, 'Miecz Glamdring', 'Potężny miecz używany przez Gandalfa w walce ze złem.', 0, 0, '2023-06-01', '2023-06-10', 0, NULL),
                        (2, 2, 'Jeden Pierścień', 'Tajemniczy pierścień o ogromnej mocy.', 1, 0, '2023-06-02', '2023-06-11', 0, NULL),
                        (3, 3, 'Amulet Yennefer', 'Magiczny amulet zwiększający moc czarów.', 0, 0, '2023-06-03', '2023-06-12', 0, NULL),
                        (4, 4, 'Medalion Wiedźmina', 'Tajemniczy medalion dający wiedźminowi nadnaturalne zdolności.', 1, 1, '2023-06-04', '2023-06-13', 0, NULL)";
    $pdo->exec($insertAuctions);

    // Wstawianie danych do tabeli message
    $insertMessages = "INSERT INTO message (mlid, date, description)
                    VALUES
                        (1, '2023-06-06', 'Czy miecz Glamdring nadal jest dostępny?'),
                        (1, '2023-06-07', 'Tak, miecz Glamdring jest wciąż dostępny. Czy jesteś zainteresowany zakupem?'),
                        (1, '2023-06-07', 'Tak, jestem zainteresowany. Czy mogę obejrzeć miecz przed zakupem?'),
                        (1, '2023-06-08', 'Oczywiście, możemy umówić się na spotkanie. Gdzie mogę Cię spotkać?'),
                        (2, '2023-06-06', 'Czy ten Jeden Pierścień jest oryginalny?'),
                        (2, '2023-06-07', 'Tak, ten Pierścień jest oryginalny i posiada potężne moce. Czy chcesz go kupić?'),
                        (2, '2023-06-07', 'Tak, jestem zainteresowany. Czy mogę go przetestować przed zakupem?'),
                        (2, '2023-06-08', 'Niestety, nie można przetestować tego Pierścienia. Ale mogę zapewnić Cię, że jest w doskonałym stanie.'),
                        (3, '2023-06-06', 'Czy amulet Yennefer jest nadal dostępny?'),
                        (3, '2023-06-07', 'Tak, amulet Yennefer jest nadal dostępny. Czy chciałbyś go zakupić?'),
                        (3, '2023-06-07', 'Tak, jestem zainteresowany. Czy mogę obejrzeć amulet osobiście?'),
                        (3, '2023-06-08', 'Oczywiście, możemy się spotkać. Gdzie chciałbyś się spotkać?'),
                        (4, '2023-06-06', 'Czy medalion Wiedźmina jest wciąż dostępny?'),
                        (4, '2023-06-07', 'Tak, medalion Wiedźmina jest nadal dostępny. Czy jesteś zainteresowany zakupem?'),
                        (4, '2023-06-07', 'Tak, jestem zainteresowany. Czy mogę obejrzeć medalion przed zakupem?'),
                        (4, '2023-06-08', 'Oczywiście, możemy umówić się na spotkanie. Gdzie chciałbyś się spotkać?')";
    $pdo->exec($insertMessages);

    echo "Dane zostały pomyślnie wstawione do bazy danych.";
} catch (PDOException $e) {
    echo "Błąd połączenia lub aktualizacji bazy danych: " . $e->getMessage();
}
?>
