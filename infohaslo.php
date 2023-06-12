<?php
$haslo="password1";
$pass = password_hash($haslo, PASSWORD_ARGON2ID);
print_r($pass);
?>