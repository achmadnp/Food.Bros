<?php
if (isset($_POST['reviewSubmit'])) {
  require 'dbconn.inc.php';
  $recipeId = $_POST['recipeId'];
  $userId = $_POST['userId'];
  $reviewText = $_POST['commentText'];

  $stmt = $conn->prepare(
    "INSERT INTO `review` (`recipe_id`, `user_id`, `review_text`) VALUES (?, ?, ?)"
  );
  $stmt->bind_param('iis', $recipeId, $userId, $reviewText);
  $stmt->execute();
  if ($stmt) {
    header(
      'Location: ../recipe-detail.php?recipeId=' . $recipeId . '&code=submitted'
    );
    $stmt->close();
    exit();
  }
}
?>
