<?php

// Ak nie je zadané meno, ukonči sa skript a vypíše sa hlásenie.
if (empty($_POST["name"])) {
    die("Name is required");
}
// Ak email nie je platný, ukonči sa  skript a vypíše sa hlásenie.
if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}
// Ak heslo nemá aspoň 8 znakov, ukonči sa skript a vypíše sa hlásenie.
if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}
// Ak heslo neobsahuje aspoň jedno písmeno, ukonči sa skript a vypíše sa hlásenie.
if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}
// Ak heslo neobsahuje aspoň jedno číslo, ukonči sa skript a vypíše sa hlásenie.
if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}
// Ak sa heslá nezhodujú, ukonči sa skript a vypíše sa hlásenie.
if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}
// Vytvorí hash hesla a uloží ho do premennej $password_hash.
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Zavolá skript na pripojenie k databáze a vráti objekt s pripojením.
$mysqli = require __DIR__ . "/database.php";

// Vytvorí sql dotaz s otáznikmi namiesto konkrétnych hodnôt.
$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        

// Vytvorí nový prepared statement.
$stmt = $mysqli->stmt_init();

// Ak sa nepodarí pripraviť dotaz, ukonči skript a vypíš chybu.
if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

// Nahradí otázniky v dotaze konkrétnymi hodnotami a binduje ich s parametrami statementu.
$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);
                  
// Ak sa podarí vykonať statement, presmeruje používateľa na stránku pre prihlásenie.
if ($stmt->execute()) {

    header("Location: login.php");
    exit;
    
} else {
    
    // Ak sa nevykoná statement, skontroluje sa, či užívateľský email už existuje v databáze a podľa toho sa vypíše chybové hlásenie.
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
