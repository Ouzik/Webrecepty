<?php

session_start(); // spustenie PHP session

if (isset($_SESSION["user_id"])) { // ak existuje session pre pouzivatela, vykonaj nasledujuci kod
    
    $mysqli = require __DIR__ . "/database.php"; // pripojenie k databaze
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}"; // SELECT query pre pouzivatela s ID, ktore je ulozene v session
            
    $result = $mysqli->query($sql); // vykonanie SELECT query
    
    $user = $result->fetch_assoc(); // ulozenie dat pouzivatela do premennej
  }


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"/>
    <title>WEB RECEPTY</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link rel="stylesheet" href="css/search.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
  </head>
  <body>


  <nav>
      <div class="logo">WEB RECEPTY</div>
      <input type="checkbox" id="click">
      <label for="click" class="menu-btn">
        <i class="fas fa-bars"></i>
      </label>
      <ul>
        <li><a class="active" href="#">Search</a></li>
        <li><a href="saved.php">Saved</a></li>
        <li><a href="random.php">Random recipe</a></li>
      </ul>
      <div class="main">
        <div class="bx bx-menu" id="menu-icon"></div>
        <?php if (isset($user)): //ak premenna $user existuje zobrazi meno ktore je ulozene v $user premennej ?>
            <p><?= htmlspecialchars($user["name"])?> </p>
            <p><a href="logout.php">Log out</a></p>
            <?php endif; ?>
    </div>
    </nav>

    <h2 class="search-title">
      Search recipes here
    </h2>

    <div class="search-body">
    <div class="box">
    <div class="search-box">
      <input type="text" class="search-input" id="search" placeholder="Search for meals">
      <label for="" class="search-btn" id="icon">
        <i class="fas fa-search"></i>
      </label>
      </div>
    </div>
  </div>

     <div class="meals-container">
        <div class="meal">
        </div>
      </div>

      <div class="pop-up-container">
        <div class="pop-up">
          <i class="fa-solid fa-x"></i>
          <div class="pop-up-inner"></div>
        </div>
      </div>
    </main>
    <footer></footer>         
     
    <script src="js/script.js"></script>
    <script src="https://kit.fontawesome.com/fd0aa4d832.js" crossorigin="anonymous"></script>
  </body>
</html>