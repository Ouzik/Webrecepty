<?php

$is_invalid = false; // premenná $is_invalid je nastavená na false

if ($_SERVER["REQUEST_METHOD"] === "POST") { //kontroluje, či bola požiadavka odoslaná pomocou metódy POST
    
    $mysqli = require __DIR__ . "/database.php"; //pripojenie k databáze pomocou súboru database.php
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"])); //SQL dotaz na vyhľadanie používateľa podľa emailovej adresy
    
    $result = $mysqli->query($sql); //vykonanie SQL dotazu
    
    $user = $result->fetch_assoc(); //uloženie nájdeného používateľa
    
    if ($user) { //ak bol používateľ nájdený
        
        if (password_verify($_POST["password"], $user["password_hash"])) { //kontrola, či sa heslo zhoduje s heslom uloženým v databáze
            
            session_start(); //spustenie session
            
            session_regenerate_id(); //vygenerovanie nového ID pre session
            
            $_SESSION["user_id"] = $user["id"];  //uloženie ID používateľa do session
            
            header("Location: Search.php"); //presmerovanie na stránku Search.php
            exit; //ukončenie skriptu

        }
    }
    
    $is_invalid = true;  //ak sa prihlasovacie údaje nezhodujú, premenná $is_invalid sa nastaví na true
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>
<section class="side">
        <img src="images/home-img.png" alt="">
    </section>

    <section class="main">
        <div class="login-container">
            <p class="title">Welcome back</p>
            <div class="separator"></div>
            <p class="welcome-message">Please, provide login credential to proceed and have access to all our services</p>

<?php if ($is_invalid): ?> 
        <em>Invalid login</em> 
    <?php endif; ?>

            <form method ="post" class="login-form">
                <div class="form-control">
                    <input type="email" name="email" id="email" placeholder="Email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                    
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-control">
                    <input type="password" name="password" id="password" placeholder="Password">
                    <i class="fas fa-lock"></i>
                </div>

                <button class="submit">Login</button>
            </form>
        </div>
    </section>
    
   

    

    
</body>
</html>
