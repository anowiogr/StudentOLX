<?php

    $dbconn = pg_connect("dbname=localhost port=5432 dbname=studentolx user=postgres password=P05tGr3s");

if (!$dbconn) {
        die("Błąd połączenia z bazą danych: " . pg_last_error());
    }

?>
