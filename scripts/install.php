<?php

require_once 'connect.php';

function checkDatabaseExists() {
    global $pdo, $dbname;

    $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
    $stmt->execute([$dbname]);
    return $stmt->rowCount() > 0;
}

function createNewDatabase() {
    global $pdo, $dbname;

    $stmt = $pdo->prepare("CREATE DATABASE IF NOT EXISTS $dbname");
    $stmt->execute();
    echo "Utworzono nową bazę danych '$dbname'.<br>";
}

function deleteExistingTables() {
    global $pdo;

    $stmt = $pdo->prepare("DROP TABLE IF EXISTS accounts, auction, category, file_to_auction, message, message_link, users");
    $stmt->execute();
    echo "Usunięto istniejące tabele z bazy danych.<br>";
}

function createAllTables() {
    global $pdo;

    $stmt = $pdo->prepare("
        -- Twój kod SQL tworzący tabele
        CREATE TABLE IF NOT EXISTS accounts (
            accountid int(11) NOT NULL AUTO_INCREMENT,
            userid int(11) NOT NULL,
            login varchar(100) NOT NULL,
            password varchar(50) NOT NULL,
            account_type int(11) NOT NULL,
            verified tinyint(1) NOT NULL,
            PRIMARY KEY (accountid)
        );

        CREATE TABLE IF NOT EXISTS auction (
            auctionid int(11) NOT NULL AUTO_INCREMENT,
            accountid int(11) NOT NULL,
            categoryid int(11) NOT NULL,
            title varchar(100) DEFAULT NULL,
            description text,
            used tinyint(1) DEFAULT NULL,
            private tinyint(1) DEFAULT NULL,
            date_start date DEFAULT NULL,
            date_end date DEFAULT NULL,
            sold tinyint(1) DEFAULT NULL,
            buyerid int(11) DEFAULT NULL,
            PRIMARY KEY (auctionid)
        );

        CREATE TABLE IF NOT EXISTS category (
            categoryid int(11) NOT NULL AUTO_INCREMENT,
            name int(11) NOT NULL,
            in_treee int(11) DEFAULT NULL,
            PRIMARY KEY (categoryid)
        );

        CREATE TABLE IF NOT EXISTS file_to_auction (
            fileid int(11) NOT NULL AUTO_INCREMENT,
            auctionid int(11) NOT NULL,
            link varchar(200) NOT NULL,
            PRIMARY KEY (fileid)
        );

        CREATE TABLE IF NOT EXISTS message (
            id int(11) NOT NULL AUTO_INCREMENT,
            mlid int(11) NOT NULL,
            date date NOT NULL DEFAULT CURRENT_TIMESTAMP,
            description text,
            PRIMARY KEY (id)
        );

        CREATE TABLE IF NOT EXISTS message_link (
            mlid int(11) NOT NULL AUTO_INCREMENT,
            sellerid int(11) NOT NULL,
            buyerid int(11) NOT NULL,
            auctionid int(11) NOT NULL,
            PRIMARY KEY (mlid)
        );

        CREATE TABLE IF NOT EXISTS users (
            userid int(11) NOT NULL AUTO_INCREMENT,
            login varchar(100) NOT NULL,
            password varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            name varchar(100) DEFAULT NULL,
            surname varchar(100) DEFAULT NULL,
            phone varchar(15) DEFAULT NULL,
            address varchar(200) DEFAULT NULL,
            postcode varchar(6) DEFAULT NULL,
            city varchar(100) DEFAULT NULL,
            province varchar(50) DEFAULT NULL,
            PRIMARY KEY (userid)
        );
    ");

    $stmt->execute();
    echo "Utworzono wszystkie tabele w bazie danych.<br>";
}

// Sprawdzanie istnienia bazy danych
if (checkDatabaseExists()) {
    echo "Baza danych '$dbname' istnieje.<br>";
    $answer = readline("Czy chcesz usunąć istniejącą bazę danych i utworzyć nową z wszystkimi tabelami? (tak/nie): ");
    if ($answer === 'tak') {
        deleteExistingTables();
        createAllTables();
    }
} else {
    echo "Baza danych '$dbname' nie istnieje.<br>";
    $answer = readline("Czy chcesz utworzyć nową bazę danych z wszystkimi tabelami? (tak/nie): ");
    if ($answer === 'tak') {
        createNewDatabase();
        createAllTables();
    }
}

?>
