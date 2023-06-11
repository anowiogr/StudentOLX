<?php
require 'connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Usuwanie istniejących tabel
    $tables = [
        'accounts',
        'type',
        'auctions',
        'category',
        'file_to_auction',
        'message',
        'message_link',
        'users'
    ];

    foreach ($tables as $table) {
        $dropTable = "DROP TABLE IF EXISTS $table";
        $pdo->exec($dropTable);
    }

    // Tworzenie bazy danych
    $createDatabase = "CREATE DATABASE IF NOT EXISTS studentolx";
    $pdo->exec($createDatabase);
    $pdo->exec("USE studentolx");

    // Tabela type
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

    // Tabela accounts
    $createAccountsTable = "CREATE TABLE IF NOT EXISTS accounts (
        accountid INT NOT NULL,
        userid INT NOT NULL,
        login VARCHAR(100) NOT NULL,
        password VARCHAR(50) NOT NULL,
        account_type VARCHAR(3) NOT NULL DEFAULT '002',
        verified TINYINT(1) NOT NULL
    )";
    
    $pdo->exec($createAccountsTable);

    // Tabela auctions
    $createAuctionTable = "CREATE TABLE IF NOT EXISTS auctions (
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
    )";
    $pdo->exec($createAuctionTable);

    // Tabela category
    $createCategoryTable = "CREATE TABLE IF NOT EXISTS category (
        categoryid INT NOT NULL,
        name INT NOT NULL,
        in_tree INT,
        PRIMARY KEY (categoryid)
    )";
    $pdo->exec($createCategoryTable);

    // Tabela file_to_auction
    $createFileToAuctionTable = "CREATE TABLE IF NOT EXISTS file_to_auction (
        fileid INT NOT NULL,
        auctionid INT NOT NULL,
        link VARCHAR(200) NOT NULL,
        PRIMARY KEY (fileid)
    )";
    $pdo->exec($createFileToAuctionTable);

    // Tabela message
    $createMessageTable = "CREATE TABLE IF NOT EXISTS message (
        id INT NOT NULL,
        mlid INT NOT NULL,
        date DATE DEFAULT CURRENT_TIMESTAMP NOT NULL,
        description TEXT,
        PRIMARY KEY (id)
    )";
    $pdo->exec($createMessageTable);

    // Tabela message_link
    $createMessageLinkTable = "CREATE TABLE IF NOT EXISTS message_link (
        mlid INT NOT NULL,
        sellerid INT NOT NULL,
        buyerid INT NOT NULL,
        auctionid INT NOT NULL,
        PRIMARY KEY (mlid)
    )";
    $pdo->exec($createMessageLinkTable);

    // Tabela users
    $createUsersTable = "CREATE TABLE IF NOT EXISTS users (
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
    )";
    $pdo->exec($createUsersTable);

    echo "Baza danych została utworzona pomyślnie.";
} catch (PDOException $e) {
    die("Błąd połączenia lub tworzenia bazy danych: " . $e->getMessage());
}
?>
