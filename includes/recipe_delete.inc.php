<?php
if (isset($_POST['delete_recipeId'])) {
  include 'dbconn.inc.php';
  $recipeId = $_POST['delete_recipeId'];

  include 'dbconn.inc.php';
  $stmt = $conn->prepare("DELETE FROM `user_recipe` WHERE `recipe_id` = ?");
  $stmt->bind_param('i', $recipeId);
  $stmt->execute();

  // Delete from `review` table
  $stmt = $conn->prepare("DELETE FROM `review` WHERE `recipe_id` = ?");
  $stmt->bind_param('i', $recipeId);
  $stmt->execute();

  $stmt = $conn->prepare("SELECT ingredient.id FROM recipe_ingredient
  JOIN ingredient ON recipe_ingredient.ingredient_id = ingredient.id
  WHERE `recipe_id` = ?");
  $stmt->bind_param('i', $recipeId);
  $stmt->execute();
  $stmt->bind_result($ingId);

  $ingredId;
  while ($stmt->fetch()) {
    $ingredId = $ingId;
  }

  $stmt->close();

  $stmt = $conn->prepare(
    "DELETE FROM `recipe_ingredient` WHERE `recipe_id` = ?"
  );
  $stmt->bind_param('i', $recipeId);
  $stmt->execute();

  // Delete from `receipt` table
  $stmt = $conn->prepare("DELETE FROM `recipe` WHERE `id` = ?");
  $stmt->bind_param('i', $recipeId);
  $stmt->execute();

  $stmt = $conn->prepare("DELETE FROM `ingredient` WHERE `id` = ?");
  $stmt->bind_param('i', $ingredId);
  $stmt->execute();

  // Close the prepared statement
  $stmt->close();

  // Close the database connection
  $conn->close();

  header('Location: ../profile.php?code=deleted');
  exit();
}
?>
