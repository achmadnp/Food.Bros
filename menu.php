<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="css/Menu.css">
    <?php include 'includes/navbar.php'; ?>
    <script src="js/menuQuery.js"></script>
</head>

<body>
    <div class="sidebar">
    <button class="sidebar-button" onclick="addQueryParameter('Alle')">Alle</button>
        <button class="sidebar-button" onclick="addQueryParameter('frühstück')">Frühstück</button>
        <button class="sidebar-button" onclick="addQueryParameter('vorspeise')">Vorspeise</button>
        <button class="sidebar-button" onclick="addQueryParameter('hauptgericht')">Hauptgericht</button>
        <button class="sidebar-button" onclick="addQueryParameter('dessert')">Dessert</button>
        <button class="sidebar-button" onclick="addQueryParameter('sidedish')">Side Dishes</button>
        <button class="sidebar-button" onclick="addQueryParameter('snacks')">Snacks</button>
        <button class="sidebar-button" onclick="addQueryParameter('getränke')">Getränke</button>
    </div>

    <div class="food-list-container">
    <?php
    include 'includes/functions.php';

    // Retrieve the "type" query parameter from the URL
    if (isset($_GET['type'])) {
      $selectedType = strtolower($_GET['type']);
    } else {
      $selectedType = 'alle';
    }

    $recipes = [];

    $result = get_all_recipe_overview();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $recipe = [
          'id' => $row['id'],
          'name' => $row['name'],
          'type' => $row['type'],
        ];
        array_push($recipes, $recipe);
      }
    }

    // Filter and retrieve recipes based on the selected type
    // Replace this with your own code to fetch data from your data source
    // Here, we are simulating the fetched data with an array

    // Check if the 'Alle' button is pressed
    if ($selectedType === 'alle') {
      // Display all recipes without filtering
      echo '<h2 class="food-list-title">Alle Kategorien</h2>
      <ul class="food-list">';
      foreach ($recipes as $recipe) {
        echo '<a href=recipe-detail.php?recipeId=' .
          $recipe['id'] .
          '><li><span>' .
          $recipe['name'] .
          '</span></li></a>';
      }
      echo '</ul>';
    } else {
      // Filter the recipes based on the selected type
      $filteredRecipes = array_filter($recipes, function ($recipe) use (
        $selectedType
      ) {
        return $selectedType === '' ||
          strtolower($recipe['type']) === $selectedType;
      });

      // Display the filtered recipes
      echo '<h2 class="food-list-title">' .
        ucfirst($selectedType) .
        '</h2>
      <ul class="food-list">';
      foreach ($filteredRecipes as $recipe) {
        echo '<a href=recipe-detail.php?recipeId=' .
          $recipe['id'] .
          '><li><span>' .
          $recipe['name'] .
          '</span></li></a>';
        echo '';
      }
      echo '</ul>';
    }
    ?>

</div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>



