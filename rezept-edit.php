<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezept Bearbeiten</title>
    <link rel="stylesheet" href="css/NeuRezept.css">
    <?php include 'includes/navbar.php'; ?>
    <?php include './includes/login_session.php'; ?>
    <?php
    if (isset($_SESSION['id']) && isset($_GET['recipeId'])) {
      require 'includes/functions.php';
      $recipeId = $_GET['recipeId'];
      $recipe = get_single_recipe($recipeId);
      $recipeName = $recipe['name'];
      $type = $recipe['type'];
      $step = $recipe['step'];
      $ingredientNames = [];
      $ingredientSizes = [];

      foreach ($recipe['ingredients'] as $ingredient) {
        // echo $ingredient['name'];
        // echo $ingredient['amount'];
        $ingredientNames = preg_split("/\,/", $ingredient['name']);
        $ingredientSizes = preg_split("/\,/", $ingredient['amount']);
      }
    }
    $recipeId = $_GET['recipeId'];

    if (isset($_POST['recipe_edit_submit'])) {
      echo 'this';
      include 'includes/functions.php';
      // Retrieve the ingredient names
      $rid = $_POST['recipeId'];
      $ingredientNames = $_POST['ingredientName'];
      $ingredientSizes = $_POST['ingredientSize'];
      $recipeName = $_POST['recipeName'];
      $step = $_POST['step'];
      $type = $_POST['foodType'];

      edit_recipe(
        $rid,
        $ingredientNames,
        $ingredientSizes,
        $recipeName,
        $type,
        $step
      );
    }
    ?>
    <script defer src="js/editRecipeutil.js"></script>
</head>
<body>
    <h1 id="rezept-titel">Rezept bearbeiten</h1>
    <?php
    echo '<form id="recipeForm" action="rezept-edit.php" method="POST">' .
      '<label for="recipeName" name="rezp">Rezeptname: </label>' .
      '<input type="hidden" name="recipeId" value="' .
      $recipeId .
      '" required>' .
      '<input type="text" id="recipeName" name="recipeName" value="' .
      $recipeName .
      '" required> <div id="foodTypesContainer">
      <h3>Typ:</h3>
      <div id="foodTypeRow">
        <input id="foodType" type="text" placeholder="Typ" name="foodType" value="' .
      $type .
      '" required>
      </div>
  </div>' .
      '<div id="ingredientsContainer">
        <h3>Zutaten:</h3>
        ';
    for ($i = 0; $i < count($ingredientNames); $i++) {
      echo '<div class="ingredientRow">
          <input type="text" class="ingredientName" placeholder="Name der Zutaten" value="' .
        $ingredientNames[$i] .
        '" required>
          <input type="text" class="ingredientSize" placeholder="Größe" value="' .
        $ingredientSizes[$i] .
        '" required>
          <button type="button" class="deleteButton" onclick="deleteIngredient(this)"><ion-icon name="trash-outline"></ion-icon></button>
        </div>';
    }
    echo '<input type="hidden" id="ingredientCount" value="1">
        </div>
    
      <button type="button" id="addIngredientButton" onclick="addIngredient()">Zutaten hinzufügen</button>
      <div id="preparationContainer">
        <h3>Vorbereitung: </h3>
        <textarea id="preparationInput" name="step" placeholder="Vorbereitungsschritte eingeben..." onkeypress="process(event, this)" required>' .
      $recipe['step'] .
      '</textarea>
      </div>

    <button type="submit" name="recipe_edit_submit">Submit</button>
  </form>';
    ?>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>