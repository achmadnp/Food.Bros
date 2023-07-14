<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezept</title>
    <link rel="stylesheet" href="css/NeuRezept.css">
    <?php include 'includes/navbar.php'; ?>
    <?php include './includes/login_session.php'; ?>
    <?php if (isset($_SESSION['id'])) {
      $userid = $_SESSION['id'];
    } ?>
    <script defer src="js/newRecipeUtil.js"></script>
</head>

<body>
<?php if (isset($_POST['recipe_create_submit'])) {
  include 'includes/functions.php';

  // Retrieve the ingredient names
  $ingredientNames = $_POST['ingredientName'];
  $ingredientSizes = $_POST['ingredientSize'];
  $recipeName = $_POST['recipeName'];
  $step = $_POST['step'];
  $type = $_POST['foodType'];

  create_new_recipe(
    $userid,
    $recipeName,
    $type,
    $step,
    $ingredientNames,
    $ingredientSizes
  );
} ?>

  <h1 id="rezept-titel">Neues Rezept erstellen</h1>
  <?php echo '<form id="recipeForm" action="rezept-new.php" method="POST">
    <label for="recipeName" name="rezp">Rezeptname: </label>
    <input type="text" id="recipeName" name="recipeName" required> 
    
    <div id="foodTypesContainer">
        <h3>Typ:</h3>
        <div id="foodTypeRow">
          <input id="foodType" type="text" placeholder="Typ" name="foodType" required>
        </div>
    </div>

      <div id="ingredientsContainer">
        <h3>Zutaten:</h3>
        <div class="ingredientRow">
          <input type="text" class="ingredientName" placeholder="Name der Zutaten" required>
          <input type="text" class="ingredientSize" placeholder="Größe" required>
          <button type="button" class="deleteButton" onclick="deleteIngredient(this)"><ion-icon name="trash-outline"></ion-icon></button>
        </div>
        <input type="hidden" id="ingredientCount" value="1">
      </div>
  
      <button type="button" id="addIngredientButton" onclick="addIngredient()">Zutaten hinzufügen</button>

      <div id="preparationContainer">
        <h3>Vorbereitung: </h3>
        <textarea name="step" id="preparationInput" onkeypress="process(event, this)" placeholder="Vorbereitungsschritte eingeben..." required></textarea>
    </div>

    <button type="submit" name="recipe_create_submit">Submit</button>
    </form>'; ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>