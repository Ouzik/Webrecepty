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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
    <script
      src="https://kit.fontawesome.com/0a9b7b3b75.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/saved.css">

    <title>Favourites</title>
  </head>
  <body>
    <main>
    <nav>
      <div class="logo">WEB RECEPTY</div>
      <input type="checkbox" id="click">
      <label for="click" class="menu-btn">
        <i class="fas fa-bars"></i>
      </label>
      <ul>
        <li><a  href="search.php">Search</a></li>
        <li><a class="active" href="saved.php">Saved</a></li>
        <li><a href="random.php">Random recipe</a></li>
      </ul>

      <div class="main">
        <div class="bx bx-menu" id="menu-icon"></div>
        <?php if (isset($user)): //ak premenna $user existuje zobrazi meno ktore je ulozene v $user premennej?>
            <p><?= htmlspecialchars($user["name"])?> </p>
            <p><a href="logout.php">Log out</a></p>
            <?php endif; ?>
    </div>
    </nav>

    
   

        <div class="fav-meals-container">
        <h1 class="search-title">Saved recipes</h1>
          <div class="fav-meals">
          </div>
        </div>
      </div>

      <!-- Display the Details of the Meals -->
      <div class="pop-up-container">
        <div class="pop-up">
          <i class="fa-solid fa-x"></i>
          <div class="pop-up-inner"></div>
        </div>
    
    </main>
    <footer></footer>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
      crossorigin="anonymous"
    ></script>
    <script src="js/saved.js"></script>
  </body>
</html>