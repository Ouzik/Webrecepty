<?php

$mysqli = require __DIR__ . "/database.php"; //Vytvorí pripojenie k databáze s použitím definovanej funkcie v súbore database.php.

$sql = sprintf("SELECT * FROM user
                WHERE email = '%s'",
                $mysqli->real_escape_string($_GET["email"])); /* Vytvára SQL príkaz, ktorý vyberie všetky stĺpce z tabuľky user, kde email je zhodný s hodnotou v $_GET["email"].
                                                                 - %s je zástupný znak pre reťazce v printf-špecifikácii formátu.
                                                                 - $mysqli->real_escape_string() slúži na escapovanie reťazcov, aby sa zabránilo SQL injection útokom.*/
                
$result = $mysqli->query($sql); //Vykoná SQL príkaz a uloží výsledok do premennej $result.

$is_available = $result->num_rows === 0; //Kontroluje, či je počet riadkov v $result rovný 0, čo znamená, že e-mailová adresa ešte nie je zaregistrovaná.

header("Content-Type: application/json"); //Nastavuje HTTP hlavičku pre typ obsahu na JSON.

echo json_encode(["available" => $is_available]); //Zakóduje PHP hodnotu do JSON formátu a vypíše ho. Toto vracia JSON objekt s jediným atribútom "available", ktorý má hodnotu $is_available.
?>