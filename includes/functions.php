<?php

function get_user_detail($id)
{
  include 'dbconn.inc.php';
  $stmt = $conn->prepare("SELECT DISTINCT * FROM user WHERE id = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();

  $result = $stmt->get_result()->fetch_assoc();
  $stmt->close();

  return $result;
}

function count_user_cont($id)
{
  include 'dbconn.inc.php';
  $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE id = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();

  $result = $stmt->get_result()->fetch_assoc();
  $stmt->close();

  return $result;
}

function get_all_recipe_overview()
{
  include 'dbconn.inc.php';
  $stmt = $conn->prepare("SELECT id, name, type FROM recipe");
  $stmt->execute();

  $result = $stmt->get_result();
  $stmt->close();
  return $result;
}

function get_single_recipe($rId)
{
  include 'dbconn.inc.php';
  $stmt = $conn->prepare("SELECT recipe.id, recipe.name, recipe.type, recipe.step, ingredient.i_name, ingredient.amount
  FROM recipe
  JOIN recipe_ingredient ON recipe.id = recipe_ingredient.recipe_id
  JOIN ingredient ON recipe_ingredient.ingredient_id = ingredient.id
  WHERE recipe.id = ?");
  $stmt->bind_param('i', $rId);
  $stmt->execute();

  $stmt->bind_result(
    $recipeId,
    $recipeName,
    $recipeType,
    $recipeStep,
    $ingredientName,
    $ingredientAmount
  );

  $recipe = null;

  while ($stmt->fetch()) {
    // Create a new recipe entry if it doesn't exist
    if ($recipe === null) {
      $recipe = [
        'id' => $recipeId,
        'name' => $recipeName,
        'type' => $recipeType,
        'step' => $recipeStep,
        'ingredients' => [],
      ];
    }

    // Add ingredient details to the recipe entry
    $recipe['ingredients'][] = [
      'name' => $ingredientName,
      'amount' => $ingredientAmount,
    ];
  }

  // Close the prepared statement
  $stmt->close();

  // Close the database connection
  $conn->close();

  // Return the recipe details
  return $recipe;
}

function get_user_recipe($id)
{
  include 'dbconn.inc.php';
  $stmt = $conn->prepare("SELECT recipe.id, recipe.name, recipe.type
  FROM recipe
  JOIN user_recipe ON recipe.id = user_recipe.recipe_id
  WHERE user_recipe.user_id = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();

  $result = $stmt->get_result();
  $stmt->close();
  return $result;
}

function create_new_recipe(
  int $userId,
  string $recipeName,
  string $recipeType,
  $steps,
  array $ingredientNames,
  array $ingredientAmount
) {
  include 'dbconn.inc.php';
  $stmt = $conn->prepare(
    "INSERT INTO `recipe` (`name`, `type`, `step`) VALUES (?, ?, ?)"
  );
  $stmt->bind_param('sss', $recipeName, $recipeType, $steps);
  $stmt->execute();

  $recipeId = $stmt->insert_id;

  // Insert into `ingredient` table and link with the recipe in `receipt_ingredient` table
  $ingredientCount = count($ingredientNames);
  for ($i = 0; $i < $ingredientCount; $i++) {
    $ingredientName = $ingredientNames[$i];
    $ingredientAmt = $ingredientAmount[$i];

    // Insert each ingredient into `ingredient` table if it doesn't exist
    $stmt = $conn->prepare(
      "INSERT IGNORE INTO `ingredient` (`i_name`, `amount`) VALUES (?, ?)"
    );
    $stmt->bind_param('ss', $ingredientName, $ingredientAmt);
    $stmt->execute();

    // Get the ingredient ID
    $ingredientId = $stmt->insert_id;

    // Link recipe with ingredients in `receipt_ingredient` table
    $stmt = $conn->prepare(
      "INSERT INTO `recipe_ingredient` (`recipe_id`, `ingredient_id`) VALUES (?, ?)"
    );
    $stmt->bind_param('ii', $recipeId, $ingredientId);
    $stmt->execute();
  }

  $stmt = $conn->prepare(
    "INSERT INTO `user_recipe` (`user_id`, `recipe_id`) VALUES (?, ?)"
  );
  $stmt->bind_param('ii', $userId, $recipeId);
  $stmt->execute();

  // Close the prepared statement
  $stmt->close();

  // Close the database connection
  $conn->close();

  header('Location: mein-rezept.php?code=created');
  exit();
}

function edit_recipe(
  $recipeId,
  $ingredientNames,
  $ingredientAmount,
  $recipeName,
  $recipeType,
  $step
) {
  include 'dbconn.inc.php';

  $stmt = $conn->prepare(
    "UPDATE `recipe` SET `name` = ?, `type` = ?, `step` = ? WHERE `id` = ?"
  );
  $stmt->bind_param('sssi', $recipeName, $recipeType, $step, $recipeId);
  $stmt->execute();

  $ingredientCount = count($ingredientNames);

  for ($i = 0; $i < $ingredientCount; $i++) {
    $ingredientName = $ingredientNames[$i];
    $ingredientAmt = $ingredientAmount[$i];

    // Check if the ingredient already exists in the `ingredient` table
    $stmt = $conn->prepare("SELECT ingredient.id FROM ingredient
    JOIN recipe_ingredient ON ingredient.id = recipe_ingredient.ingredient_id
    JOIN recipe ON recipe_ingredient.recipe_id = recipe.id
    WHERE recipe_ingredient.recipe_id = ?");
    $stmt->bind_param('s', $recipeId);
    $stmt->execute();
    $stmt->store_result();

    // If the ingredient exists, update its amount
    if ($stmt->num_rows > 0) {
      $stmt->bind_result($ingredientId);
      $stmt->fetch();

      $stmt = $conn->prepare(
        "UPDATE `ingredient` SET `amount` = ?, `i_name` = ? WHERE `id` = ?"
      );
      $stmt->bind_param('ssi', $ingredientAmt, $ingredientName, $ingredientId);
      $stmt->execute();
    }
    // If the ingredient does not exist, insert it into the `ingredient` table
    else {
      $stmt = $conn->prepare(
        "INSERT INTO `ingredient` (`i_name`, `amount`) VALUES (?, ?)"
      );
      $stmt->bind_param('ss', $ingredientName, $ingredientAmt);
      $stmt->execute();

      $ingredientId = $stmt->insert_id;
    }

    // Update the ingredient ID in the `receipt_ingredient` table
    $stmt = $conn->prepare(
      "UPDATE `recipe_ingredient` SET `ingredient_id` = ? WHERE `recipe_id` = ?"
    );
    $stmt->bind_param('ii', $ingredientId, $recipeId);
    $stmt->execute();
  }

  // Close the prepared statement
  $stmt->close();

  // Close the database connection
  $conn->close();

  header('Location: mein-rezept.php?code=deleted');
  exit();
}

function getComments($recipeId)
{
  include 'dbconn.inc.php';
  $stmt = $conn->prepare(
    "SELECT review.review_text, user.username FROM `review` 
    JOIN user ON review.user_id = user.id
    WHERE recipe_id = ?"
  );
  $stmt->bind_param('i', $recipeId);
  $stmt->execute();

  $result = $stmt->get_result();
  $stmt->close();

  return $result;
}
