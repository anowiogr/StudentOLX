<?php
$host = "localhost";
$dbname = "your_database_name";
$user = "your_username";
$password = "your_password";

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
        accountid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(100) NOT NULL,
        password VARCHAR(250) NOT NULL,
        account_type VARCHAR(3) NOT NULL DEFAULT '222',
        verified TINYINT(1) NOT NULL,
        firstname VARCHAR(50),
        lastname VARCHAR(150),
        email VARCHAR(250),
        phone VARCHAR(9),
        address VARCHAR(200),
        codezip VARCHAR(6),
        city VARCHAR(50),
        country VARCHAR(50)
    )";
    $pdo->exec($createAccountsTable);

    // Tworzenie tabeli auctions
    $createAuctionTable = "CREATE TABLE IF NOT EXISTS auctions (
        auctionid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        accountid INT NOT NULL,
        categoryid INT NOT NULL,
        title VARCHAR(100),
        description TEXT,
        used TINYINT(1),
        private TINYINT(1),
        date_start DATE,
        date_end DATE,
        selled TINYINT(1),
        buyerid INT
    )";
    $pdo->exec($createAuctionTable);

    // Tworzenie tabeli category
    $createCategoryTable = "CREATE TABLE IF NOT EXISTS category (
        categoryid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        in_tree INT
    )";
    $pdo->exec($createCategoryTable);

    // Tworzenie tabeli file_to_auction
    $createFileToAuctionTable = "CREATE TABLE IF NOT EXISTS file_to_auction (
        file_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        auction_id INT(11) NOT NULL,
        filename VARCHAR(255) NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        FOREIGN KEY (auction_id) REFERENCES auctions(auctionid) ON DELETE CASCADE
    )";
    $pdo->exec($createFileToAuctionTable);

    // Tworzenie tabeli message
    $createMessageTable = "CREATE TABLE IF NOT EXISTS message (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        mlid INT NOT NULL,
        date DATE DEFAULT CURRENT_TIMESTAMP NOT NULL,
        description TEXT
    )";
    $pdo->exec($createMessageTable);

    // Tworzenie tabeli message_link
    $createMessageLinkTable = "CREATE TABLE IF NOT EXISTS message_link (
        mlid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        sellerid INT NOT NULL,
        buyerid INT NOT NULL,
        auctionid INT NOT NULL
    )";
    $pdo->exec($createMessageLinkTable);

    // Wstawianie danych do tabeli category
    $insertCategories = "INSERT INTO category (categoryid, name, in_tree)
                    VALUES
                        (1, 'Motoryzacja', 0),
                        (3, 'Praca', 0),
                        (4, 'Zdrowie i Uroda', 0),
                        (5, 'Elektronika', 0),
                        (6, 'Moda', 0),
                        (7, 'Zwierzęta', 0),
                        (8, 'Wypożyczalnia', 0),
                        (9, 'Sport', 0),
                        (10, 'Hobby', 0)";
    $pdo->exec($insertCategories);

    echo "Baza danych została utworzona pomyślnie.";
} catch (PDOException $e) {
    die("Błąd połączenia lub tworzenia bazy danych: " . $e->getMessage());
}
?>
