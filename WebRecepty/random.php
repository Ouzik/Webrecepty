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
    <title>Meal Finder</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link rel="stylesheet" href="css/random.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
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
        <li><a  href="Search.php">Search</a></li>
        <li><a href="saved.php">Saved</a></li>
        <li><a class="active" href="random.php">Random recipe</a></li>
      </ul>
  
      <div class="main">
        <div class="bx bx-menu" id="menu-icon"></div>
        <?php if (isset($user)):  //ak premenna $user existuje zobrazi meno ktore je ulozene v $user premennej?>
            <p><?= htmlspecialchars($user["name"])?> </p>
            <p><a href="logout.php">Log out</a></p>
            <?php endif; ?>
    </div>
    </nav>

   
   <h1 class="search-title">Random Meals</h1>
   
      </a>
 
      <div class="meals-container">
       
      <a 
          id="random"
          class="btn-primary  btn-outline-success rounded-4 random-btn p-3">
          Find random meal
        </a>
        </div>
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
    

    <script src="js/random.js"></script>
    <script src="https://kit.fontawesome.com/fd0aa4d832.js" crossorigin="anonymous"></script>
</body>
</html>