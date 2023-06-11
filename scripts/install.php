<?php
require 'connect.php';

try {
    $pdo = new PDO("mysql:host=$host", $user, $password);
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
        PRIMARY KEY (mlid)
    )";
    $pdo->exec($createMessageLinkTable);

    echo "Baza danych została utworzona pomyślnie.";
} catch (PDOException $e) {
    die("Błąd połączenia lub tworzenia bazy danych: " . $e->getMessage());
}
?>
