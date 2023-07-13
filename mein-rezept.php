<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Meine Rezepte</title>
    <link rel="stylesheet" href="./css/MeineRezept.css" />
    <?php include 'includes/navbar.php'; ?>
    <?php include './includes/login_session.php'; ?>

    <script defer src="js/deleteRecipeXML.js"></script>

  </head>
  <body>

    <h1>Meine Rezepte</h1>  
    <a href='rezept-new.php'><button id="btn">Neues Rezept addieren</button><a>
    
    <?php
    include 'includes/functions.php';

    $recipes = [];
    $result = get_user_recipe($_SESSION['id']);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $recipe = [
          'name' => $row['name'],
          'type' => $row['type'],
          'id' => $row['id'],
        ];
        array_push($recipes, $recipe);
      }
    }
    echo '<ul id="recipe-list">';
    foreach ($recipes as $recipe) {
      echo '<li class="recipe-item">
      <div class="recipe-info">
        <span>' .
        $recipe['name'] .
        '</span>
        <span class="recipe-type">' .
        $recipe['type'] .
        '</span>
      </div>

      <div>
      <a href="rezept-edit.php?recipeId=' .
        $recipe['id'] .
        '"><button class="btn-action">Bearbeiten</button></a>

      <button id="delete_recipe" data-rid=' .
        $recipe['id'] .
        ' class="btn-action">Löschen</button>
    </div>
        
        
    </li>';
    }
    echo '</ul>';
    ?>


  </body>
</html>
