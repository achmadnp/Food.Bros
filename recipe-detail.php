<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rezeptdetails</title>
  <link rel="stylesheet" href="css/rezept.css">
  <?php include 'includes/navbar.php'; ?>
</head>

<body>
<?php if (isset($_GET['recipeId'])) {
  require 'includes/functions.php';
  $recipeId = $_GET['recipeId'];
  $recipeDetail = get_single_recipe($recipeId);
  $recipeName = $recipeDetail['name'];
  $type = $recipeDetail['type'];
  $step = $recipeDetail['step'];
  $ingredientNames = [];
  $ingredientSizes = [];

  foreach ($recipeDetail['ingredients'] as $ingredient) {
    $ingredientNames = preg_split("/\,/", $ingredient['name']);
    $ingredientSizes = preg_split("/\,/", $ingredient['amount']);
  }

  if (isset($_POST['reviewSubmit'])) {
    echo 'this';
  }

  echo '<div id="recipeContainer">
  <h1>Rezeptdetails</h1>
  <p><strong>Rezeptname:</strong>' .
    $recipeName .
    '</p><h3>Typ:</h3><p>' .
    $type .
    '</p>
    <h3>Zutaten:</h3>
    <ul>';
  for ($i = 0; $i < count($ingredientNames); $i++) {
    echo '
        <li><span>' .
      $ingredientNames[$i] .
      ' - ' .
      $ingredientSizes[$i] .
      '</span>';
  }
  echo '</ul>
    <h3>Vorbereitung:</h3>
    <p>
    ' .
    $step .
    '</p>';

  if (isset($_SESSION['id'])) {
    echo '    <form id="commentForm" action="includes/reviewPost.inc.php" method="POST">
      <h3>Kommentare:</h3>
      <textarea name="commentText" id="commentInput" placeholder="Write your comment here..." required></textarea>
      <input type="hidden" value=' .
      $recipeId .
      ' name="recipeId" />
    <input type="hidden" value=' .
      $_SESSION['id'] .
      ' name="userId" />
      <button type="submit" name="reviewSubmit">Einreichen</button>
    </form>';
  }

  echo '<div id="commentSection">
    <h2>Kommentare:</h2>';

  $comments = [];
  $result = getComments($recipeId);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $comment = [
        'username' => $row['username'],
        'text' => $row['review_text'],
      ];
      array_push($comments, $comment);
    }
  }
  echo '<ul id="commentList" class="commentList">';
  foreach ($comments as $comment) {
    echo '<li>
    <div id="comment">
      <span id="username">' .
      $comment['username'] .
      '</span>
      <span id="comment-text">' .
      $comment['text'] .
      '</span>
    </div>
  </li>';
  }
  echo '</ul>
    </div>
  </div>';
} ?>
</body>

</html>