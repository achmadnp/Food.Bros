<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="./css/nav.css" />

  </head>

  <body>
    <header>
      <h1 class="logo">FOOD.BROS</h1>
      <nav class="navigation">
        <a class="nav-menu" href="home.php">HOME</a>
        <a class="nav-menu" href="menu.php">MENÜ</a>
        <a class="nav-menu" href="profile.php">MEIN KONTO</a>
        <a class="nav-menu" href="mein-rezept.php">MEINE REZEPTE</a>

        <?php if (isset($_SESSION['user'])) {
          $user = $_SESSION['user'];
          echo "<span class='user'>$user</span>";
        } ?>
        
        <?php if (isset($_SESSION['user'])) {
          echo '<a class="btn" href="includes/logout.inc.php">Ausloggen</a>';
        } else {
          echo '<a class="btn" href="login.php">Anmelden</a>';
        } ?>


      </nav>
    </header>


  </body>
</html>
