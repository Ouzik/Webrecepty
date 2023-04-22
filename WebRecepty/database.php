<?php

$host = "localhost"; // deklarovaná štandardná premenná $host s hodnotou "localhost", ktorá určuje server, kde sa nachádza databáza.
$dbname = "login_db"; //deklarovaná štandardná premenná $dbname s hodnotou "login_db", ktorá určuje názov databázy, ku ktorej sa chceme pripojiť.
$username = "root";  // deklarovaná štandardná premenná $username s hodnotou "root", ktorá určuje používateľské meno pre pripojenie k databáze
$password = ""; //deklarovaná štandardná premenná $password s hodnotou "", ktorá určuje heslo pre pripojenie k databáze.

$mysqli = new mysqli(hostname: $host,  //vytvorenie novej inštancie triedy mysqli s parametrami $host, $username, $password a $dbname. Trieda mysqli poskytuje rozhranie pre prácu s databázou MySQL.
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error); //Ak pripojenie k databáze zlyhá,vypíše sa chybová hláška, ktorá sa získa volaním metódy $mysqli->connect_error, a skript sa ukončí.
}

return $mysqli; //vracia objekt $mysqli, ktorý predstavuje aktívne pripojenie k databáze
?>