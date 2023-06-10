<?php

require_once 'connect.php';

function checkDatabaseExists() {
    global $dbconn;

    try {
        $result = pg_query($dbconn, "SELECT datname FROM pg_catalog.pg_database WHERE datname = 'studentolx'");
        return pg_num_rows($result) > 0;
    } catch (Exception $e) {
        return false;
    }
}

function createNewDatabase() {
    global $dbconn;

    try {
        pg_query($dbconn, "DROP DATABASE IF EXISTS studentolx");
        pg_query($dbconn, "CREATE DATABASE studentolx WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Polish_Poland.1250'");
        echo "Utworzono nową bazę danych 'studentolx'.<br>";
    } catch (Exception $e) {
        echo "Wystąpił błąd podczas tworzenia nowej bazy danych: " . pg_last_error();
    }
}

function deleteExistingTables() {
    global $dbconn;

    try {
        pg_query($dbconn, "DROP TABLE IF EXISTS public.accounts");
        pg_query($dbconn, "DROP TABLE IF EXISTS public.auction");
        pg_query($dbconn, "DROP TABLE IF EXISTS public.category");
        pg_query($dbconn, "DROP TABLE IF EXISTS public.file_to_auction");
        pg_query($dbconn, "DROP TABLE IF EXISTS public.message");
        pg_query($dbconn, "DROP TABLE IF EXISTS public.message_link");
        pg_query($dbconn, "DROP TABLE IF EXISTS public.users");
        echo "Usunięto istniejące tabele z bazy danych.<br>";
    } catch (Exception $e) {
        echo "Wystąpił błąd podczas usuwania tabel: " . pg_last_error();
    }
}

function createAllTables() {
    global $dbconn;

    try {
        pg_query($dbconn, "
            -- Twój kod SQL tworzący tabele
            CREATE TABLE IF NOT EXISTS public.accounts (
                accountid integer NOT NULL,
                userid integer NOT NULL,
                login character(100) NOT NULL,
                password character(50) NOT NULL,
                account_type integer NOT NULL,
                veryfied boolean NOT NULL
            );
            
            CREATE TABLE IF NOT EXISTS public.auction (
                auctionid integer NOT NULL,
                accountid integer NOT NULL,
                categoryid integer NOT NULL,
                title character(100),
                desctription text,
                used boolean,
                private boolean,
                date_start date,
                date_end date,
                selled boolean,
                buyerid integer
            );
            
            CREATE TABLE IF NOT EXISTS public.category (
                categoryid integer NOT NULL,
                name integer NOT NULL,
                in_treee integer
            );
            
            CREATE TABLE IF NOT EXISTS public.file_to_auction (
                fileid integer NOT NULL,
                auctionid integer NOT NULL,
                link character(200) NOT NULL
            );
            
            CREATE TABLE IF NOT EXISTS public.message (
                id integer NOT NULL,
                mlid integer NOT NULL,
                date date DEFAULT now() NOT NULL,
                description text
            );
            
            CREATE TABLE IF NOT EXISTS public.message_link (
                mlid integer NOT NULL,
                sellerid integer NOT NULL,
                buyerid integer NOT NULL,
                auctionid integer NOT NULL
            );
            
            CREATE TABLE IF NOT EXISTS public.users (
                userid integer NOT NULL,
                login character(100) NOT NULL,
                password character(100) NOT NULL,
                email character(100) NOT NULL,
                name character(100),
                surname character(100),
                phone character(15),
                address character(200),
                postcode character(6),
                city character(100),
                province character(50)
            );
        ");
        
        echo "Utworzono wszystkie tabele w bazie danych.<br>";
    } catch (Exception $e) {
        echo "Wystąpił błąd podczas tworzenia tabel: " . pg_last_error();
    }
}

// Sprawdzanie istnienia bazy danych
if (checkDatabaseExists()) {
    echo "Baza danych 'studentolx' istnieje.<br>";
    $answer = readline("Czy chcesz usunąć istniejącą bazę danych i utworzyć nową z wszystkimi tabelami? (tak/nie): ");
    if ($answer === 'tak') {
        deleteExistingTables();
        createAllTables();
    }
} else {
    echo "Baza danych 'studentolx' nie istnieje.<br>";
    $answer = readline("Czy chcesz utworzyć nową bazę danych z wszystkimi tabelami? (tak/nie): ");
    if ($answer === 'tak') {
        createNewDatabase();
        createAllTables();
    }
}

?>
